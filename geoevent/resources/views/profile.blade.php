<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        <title>Profile</title><style>body {
            background: rgb(255, 255, 255)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }

        .navbar {
            background-color: grey;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('index') }}">GeoEvent<i class='bx bxs-map'></i></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>

                <p> ' '</p>
                <li class="nav-item">
                    <a href="{{ route('profile') }}"><button type="submit" class="btn btn-success">Profile &
                            Data</button></a>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success_delete') }}
            </div>
        @endif
    </div>

    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-2 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        width="150px"
                        src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                        class="font-weight-bold">{{ session('name') }}</span><span
                        class="text-black-50">{{ session('email') }}</span><span> </span></div>
            </div>
            <div class="col-md-10 border-right">
                <div class="p-3 py-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>locID</th>
                                <th>User ID</th>

                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Range</th>
                                <td>Created At</td>
                                <td>Updated At</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                                <tr>
                                    <td>{{ $location->locid }}</td>
                                    <td>{{ $location->userid }}</td>

                                    <td>{{ $location->latitude }}</td>
                                    <td>{{ $location->longitude }}</td>
                                    <td>{{ $location->address }}</td>
                                    <td>{{ $location->description }}</td>
                                    <td>{{ $location->range }}</td>
                                    <td>{{ $location->created_at }}</td>
                                    <td>{{ $location->updated_at }}</td>
                                    <td>
                                        <form action="{{ route('delete_loc', ['locid' => $location->locid]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No locations found for this user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</body>

</html>
