<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GEOEVENT - Monitor Geoevents Around You</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
    .hero {
      background-image: url('lbg.avif');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 100px 0;
      text-align: center;
      align-content: center;
      text-align: center;
      height: 600px;
    }
    .hero h1 {
      font-size: 3rem;
      text-shadow: 0 4px 8px rgb(34, 34, 34);
    }
    .hero p {
      font-size: 1.9rem;
      margin-bottom: 70px;
      text-shadow: 0 4px 8px rgb(34, 34, 34);
    }
    .hero a{
        font-size: 25px;
        box-shadow: 0 4px 8px rgba(48, 47, 47, 0.1);
    }
    .feature-card {
      margin: 20px 0;
    }
    .card{
        border: thin 2px rgb(43, 42, 42);
        box-shadow: 0 4px 8px rgba(48, 47, 47, 0.1);
    }
    .feature-card .icon {
        color: rgb(1, 19, 3);
      font-size: 3rem;
      margin-bottom: 15px;
    }
    .step .icon {
        color: rgb(4, 2, 32);
      font-size: 3rem;
      margin-bottom: 15px;
    }
    footer {
      background-color: #333;
      color: white;
      padding: 30px 0;
    }
    footer a {
      color: white;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" style="font-size: 30px;"><strong>GeoEvent<i class='bx bxs-map'></i></strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="#home">About Us</a></li>
        <li class="nav-item"><a class="btn btn-primary" href="{{route('login')}}">Sign In</a></li>
      </ul>
    </div>
  </nav>

  <section class="hero" id="home">
    <div class="container">
      <h1>Discover and Monitor Geoevents Around You</h1>
      <p>Stay informed about events happening in your selected locations.</p>
      <a href="{{route('login')}}" class="btn btn-lg btn-primary">Get Started</a>
    </div>
  </section>

  <section id="features" class="py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-6 col-lg-3 feature-card">
          <div class="card">
            <div class="card-body">
              <div class="icon">
                <i class="fas fa-map-marked-alt"></i>
              </div>
              <h5 class="card-title">Interactive Map</h5>
              <p class="card-text">Monitor geoevents in real-time using Google Maps.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 feature-card">
          <div class="card">
            <div class="card-body">
              <div class="icon">
                <i class="fas fa-bell"></i>
              </div>
              <h5 class="card-title">Real-time Alerts</h5>
              <p class="card-text">Notifications for events in chosen areas.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 feature-card">
          <div class="card">
            <div class="card-body">
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <h5 class="card-title">Customizable Locations</h5>
              <p class="card-text">Add and manage multiple locations.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 feature-card">
          <div class="card">
            <div class="card-body">
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <h5 class="card-title">Community Insights</h5>
              <p class="card-text">User-generated content and reviews about events.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="how-it-works" class="f bg-light py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-sm-6 col-md-3 step">
          <div class="icon">
            <i class="fas fa-user-plus"></i>
          </div>
          <h5>Sign Up</h5>
          <p>Create an account to get started.</p>
        </div>
        <div class="col-sm-6 col-md-3 step">
          <div class="icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h5>Add Locations</h5>
          <p>Select areas on the map.</p>
        </div>
        <div class="col-sm-6 col-md-3 step">
          <div class="icon">
            <i class="fas fa-bell"></i>
          </div>
          <h5>Receive Alerts</h5>
          <p>Get notifications about events.</p>
        </div>
        <div class="col-sm-6 col-md-3 step">
          <div class="icon">
            <i class="fas fa-info-circle"></i>
          </div>
          <h5>Stay Updated</h5>
          <p>Explore detailed event information.</p>
        </div>
      </div>
    </div>
  </section>


  {{-- <section id="pricing" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5">Pricing Plans</h2>
      <div class="row text-center">
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Free</h5>
              <p class="card-text">$0/month</p>
              <p>Basic features for individuals</p>
              <a href="#" class="btn btn-primary">Choose Plan</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Standard</h5>
              <p class="card-text">$9.99/month</p>
              <p>Advanced features for power users</p>
              <a href="#" class="btn btn-primary">Choose Plan</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Premium</h5>
              <p class="card-text">$19.99/month</p>
              <p>All features and priority support</p>
              <a href="#" class="btn btn-primary">Choose Plan</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

  <footer class="text-center">
    <div class="container">
      <p>&copy; 2024 GEOEVENT. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
