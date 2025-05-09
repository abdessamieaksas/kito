<section class="banner_main" id="home">
    <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
       <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
       </ol>
       <div class="carousel-inner">
          <div class="carousel-item active">
             <img class="first-slide" src="images/banner1.jpg" alt="First slide">
             <div class="container">
             </div>
          </div>
          <div class="carousel-item">
             <img class="second-slide" src="images/banner2.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
             <img class="third-slide" src="images/banner3.jpg" alt="Third slide">
          </div>
       </div>
       <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
       <span class="carousel-control-prev-icon" aria-hidden="true"></span>
       <span class="sr-only">Previous</span>
       </a>
       <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
       <span class="carousel-control-next-icon" aria-hidden="true"></span>
       <span class="sr-only">Next</span>
       </a>
    </div>
    <div class="booking_ocline">
       <div class="container">
          <div class="row">
             <div class="col-md-5">
                <div class="book_room">
                   <h1>Book a Room Online</h1>
                   @auth
                       <div class="row">
                           <div class="col-md-12 text-center">
                               <a href="{{ route('rooms.available') }}" class="book_btn">Search Available Rooms</a>
                           </div>
                       </div>
                   @else
                       <div class="row">
                           <div class="col-md-12 text-center">
                               <p class="text-white mb-3">Please login to book a room</p>
                               <a href="{{ route('login') }}" class="book_btn">Login to Book</a>
                           </div>
                       </div>
                   @endauth
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>

