<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performing Laravel CRUD Operations</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white"> Performing laravel crud operations </div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4"> Edit Employees</div>
            <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
        </div>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card border-0 shadow-lg py-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" placeholder="Enter name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $employee->name) }}">
                        @error('name')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" name="email" id="email" placeholder="Enter email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $employee->email) }}">
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Address:</label>
                        <textarea name="address" id="address" cols="30" rows="4" class="form-control">{{ old('address', $employee->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label"></label>
                        <input type="file" name="image" id="image"
                            class="@error('image') is-invalid @enderror">
                        @error('image')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror

                        <div class="pt-3">
                            @if ($employee->image != '' && file_exists(public_path() . '/uploads/employees/' . $employee->image))
                                <img src="{{ url('/uploads/employees/' . $employee->image) }}" alt=""
                                    width="100" height="100">
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <button class="btn btn-primary my-3">Update Employees</button>
        </form>
    </div>
</body>

</html>
