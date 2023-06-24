<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>index Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <div class="container my-5">
        <div class="d-flex justify-content-between">
            <div>
                <h1>Our Courses</h1>
                <a href="{{ route('courses.create') }}" class="btn btn-info">Add New</a>
            </div>

            <form action="" method="GET" class="mt-4" id="filter_form">
                @csrf
                <input type="hidden" name="page" value="{{ request()->page }}">
                <label>Item Per Page</label>
                <select name="items_count" id="items_count">
                    <option {{ request()->items_count == 5 ? 'selected' : '' }}>5</option>
                    <option {{ request()->items_count == 10 ? 'selected' : '' }}>10</option>
                    <option {{ request()->items_count == 15 ? 'selected' : '' }}>15</option>
                    <option {{ request()->items_count == 20 ? 'selected' : '' }}>20</option>
                    <option {{ request()->items_count == 25 ? 'selected' : '' }}>25</option>
                </select>
                <button class="btn btn-dark btn-sm">filter</button>
            </form>
        </div>

        <form action="" method="" class="row">
            @csrf
            <div class="form-group col-lg-4 mt-2">
                <input type="text" class="form-control" placeholder="Name" name="name">
            </div>

            <div class="form-group col-lg-4 mt-2">
                <button class="btn btn-info">Search</button>
            </div>
        </form>

        <table class="table table-bordered mt-3">
            <tr class="table-dark text-center">
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>

            @foreach ($courses as $course)
                <tr class="text-center">
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->price }}$</td>
                    <td><img width="80" src="{{ asset('uploads/'.$course->image) }}" alt=""></td>
                    <td>{{ $course->created_at }}</td>
                    <td>
                        <a href="{{ route('courses.edit',$course->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('courses.destroy',$course->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button onclick="confirm('Are You Deleted !!!')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $courses->appends($_GET)->links() }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script>
        $('#items_count').change(function() {
            $('#filter_form').submit();
        })
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 3000);
    </script>
</body>

</html>
