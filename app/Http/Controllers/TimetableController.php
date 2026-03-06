<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // Eager load relationships to prevent N+1 query problems
        $query = Timetable::with(['schoolClass', 'section', 'subject', 'teacher'])
            ->where('tenant_id', $tenant_id);

        // Optional: Add filtering by Class and Section for the index view
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        $timetables = $query->orderBy('day_of_week')->orderBy('start_time')->get();
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();

        return view('school_admin.timetable.index', compact('timetables', 'classes', 'sections'));
    }

    public function create()
    {
        $tenant_id = $this->getTenantId();

        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();
        $subjects = Subject::where('tenant_id', $tenant_id)->where('status', 1)->get();
        $teachers = Teacher::where('tenant_id', $tenant_id)->where('status', 1)->get();

        return view('school_admin.timetable.create', compact('classes', 'sections', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id'    => 'required|exists:classes,id',
            'section_id'  => 'required|exists:sections,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
        ]);

        $validated['tenant_id'] = $this->getTenantId();

        // Check for Teacher Time Clashes
        $clash = Timetable::where('tenant_id', $validated['tenant_id'])
            ->where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($clash) {
            return back()->withInput()->with('error', 'Teacher is already assigned to another class during this time!');
        }

        Timetable::create($validated);

        return redirect()->route('school_admin.timetable.index')
            ->with('success', 'Timetable slot created successfully!');
    }

    public function edit($id)
    {
        $tenant_id = $this->getTenantId();

        // Fetch the specific timetable entry
        $timetable = Timetable::where('tenant_id', $tenant_id)->findOrFail($id);

        // Load all the options for the dropdowns
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();
        $subjects = Subject::where('tenant_id', $tenant_id)->where('status', 1)->get();
        $teachers = Teacher::where('tenant_id', $tenant_id)->where('status', 1)->get();

        return view('school_admin.timetable.edit', compact('timetable', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = $this->getTenantId();

        $timetable = Timetable::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'class_id'    => 'required|exists:classes,id',
            'section_id'  => 'required|exists:sections,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
        ]);

        // Check for Teacher Time Clashes (Make sure to IGNORE the current record's ID)
        $clash = Timetable::where('tenant_id', $tenant_id)
            ->where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('id', '!=', $id) // <-- This prevents it from clashing with itself
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($clash) {
            return back()->withInput()->with('error', 'Teacher is already assigned to another class during this time!');
        }

        $timetable->update($validated);

        return redirect()->route('school_admin.timetable.index')
            ->with('success', 'Timetable slot updated successfully!');
    }

    public function destroy($id)
    {
        $timetable = Timetable::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $timetable->delete();

        return redirect()->route('school_admin.timetable.index')
            ->with('success', 'Timetable slot deleted successfully!');
    }
}
