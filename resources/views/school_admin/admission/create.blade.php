@extends('school_admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Student Admission</h4>
                    <p class="card-description">
                        Enter a valid Student Registration Number to begin admission.
                    </p>

                    @if (!$activeYear)
                        <div class="alert alert-warning">Please make sure to set an Active Academic Year in settings soon!
                        </div>
                    @endif

                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6 form-group">
                            <label for="search_student_id">Student Registration Number (e.g., SCH0001) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_student_id"
                                    placeholder="Enter Registration No...">
                                <button class="btn btn-primary" type="button" id="btn-search-student">
                                    <i class="mdi mdi-magnify"></i> Search
                                </button>
                            </div>
                            <span class="text-danger small mt-1 d-none" id="search-error"></span>
                        </div>
                    </div>

                    <div id="admission-form-section" style="display: none;">
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2"></i>
                            <span>Student Found! Proceed with admission.</span>
                        </div>

                        <form class="forms-sample" method="POST" action="{{ route('school_admin.students.store') }}">
                            @csrf
                            @if ($activeYear)
                                <input type="hidden" name="year_id" value="{{ $activeYear->id }}">
                            @endif

                            <input type="hidden" name="student_id" id="hidden_student_id">

                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label>Student Full Name</label>
                                    <input type="text" class="form-control" id="display_student_name" readonly>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="admission_date">Admission Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('admission_date') is-invalid @enderror"
                                        name="admission_date" id="admission_date"
                                        value="{{ old('admission_date', date('Y-m-d')) }}" required>
                                    @error('admission_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="class_id">Class <span class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('class_id') is-invalid @enderror"
                                        name="class_id" id="class_id" required>
                                        <option value="">-- Select Class --</option>
                                        @foreach ($classes as $cls)
                                            <option value="{{ $cls->id }}"
                                                {{ old('class_id') == $cls->id ? 'selected' : '' }}>
                                                {{ $cls->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="section_id">Section <span class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('section_id') is-invalid @enderror"
                                        name="section_id" id="section_id" required>
                                        <option value="">-- Select Section --</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('section_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="roll_number">Roll Number</label>
                                    <input type="text" class="form-control @error('roll_number') is-invalid @enderror"
                                        name="roll_number" id="roll_number" value="{{ old('roll_number') }}"
                                        placeholder="e.g., 101">
                                    @error('roll_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="fees_pay">Admission Fees Paid?</label>
                                    <select class="form-control form-select @error('fees_pay') is-invalid @enderror"
                                        name="fees_pay" id="fees_pay">
                                        <option value="0" {{ old('fees_pay') == '0' ? 'selected' : '' }}>No / Pending
                                        </option>
                                        <option value="1" {{ old('fees_pay') == '1' ? 'selected' : '' }}>Yes / Paid
                                        </option>
                                    </select>
                                    @error('fees_pay')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 me-2">Submit Admission</button>
                            <a href="{{ route('school_admin.students.index') }}" class="btn btn-light mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBtn = document.getElementById('btn-search-student');
            const searchInput = document.getElementById('search_student_id');
            const errorSpan = document.getElementById('search-error');
            const formSection = document.getElementById('admission-form-section');

            // Hidden input and display input
            const hiddenStudentId = document.getElementById('hidden_student_id');
            const displayStudentName = document.getElementById('display_student_name');

            searchBtn.addEventListener('click', function() {
                let regNo = searchInput.value.trim();

                if (regNo === '') {
                    showError('Please enter a Registration Number.');
                    return;
                }

                // Reset state
                errorSpan.classList.add('d-none');
                formSection.style.display = 'none';
                searchBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Searching...';
                searchBtn.disabled = true;

                // Send AJAX request
                fetch(`{{ route('school_admin.search') }}?reg_no=${regNo}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        searchBtn.innerHTML = '<i class="mdi mdi-magnify"></i> Search';
                        searchBtn.disabled = false;

                        if (data.success) {
                            // Populate hidden form field with DB ID and show name
                            hiddenStudentId.value = data.student.id;
                            displayStudentName.value = data.student.name;

                            // Reveal the form
                            formSection.style.display = 'block';
                        } else {
                            showError(data.message);
                        }
                    })
                    .catch(error => {
                        searchBtn.innerHTML = '<i class="mdi mdi-magnify"></i> Search';
                        searchBtn.disabled = false;
                        showError('Server error occurred. Please try again.');
                    });
            });

            function showError(message) {
                errorSpan.textContent = message;
                errorSpan.classList.remove('d-none');
            }
        });
    </script>
@endsection
