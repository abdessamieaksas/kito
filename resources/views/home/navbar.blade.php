<header>
    <!-- header inner -->
    <div class="header">
       <div class="container">
          <div class="row">
             <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                <div class="full">
                   <div class="center-desk">
                      <div class="logo">
                         <a href="{{ route('home') }}"><img src="images/logo.png" alt="#" /></a>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                <nav class="navigation navbar navbar-expand-md navbar-dark ">
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                   <span class="navbar-toggler-icon"></span>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarsExample04">
                      <ul class="navbar-nav mr-auto">
                         <li class="nav-item active">
                            <a class="nav-link" href="#home">Home</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#room">Our room</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#gallery">Gallery</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#blog">Blog</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact Us</a>
                         </li>
                        @if (Route::has('login'))
                        @auth
                        <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-user-circle mr-2"></i>
                               {{ Auth::user()->name }}
                           </a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                               <h6 class="dropdown-header">{{ Auth::user()->email }}</h6>
                               <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                   <i class="fa fa-user mr-2"></i> Profile
                               </a>
                               <div class="dropdown-divider"></div>
                               <form method="POST" action="{{ route('logout') }}">
                                   @csrf
                                   <button class="dropdown-item" type="submit">
                                       <i class="fa fa-sign-out mr-2"></i> Log Out
                                   </button>
                               </form>
                           </div>
                       </li>
           
                        @else
                        <li class="nav-item">
                           <a
                           href="{{ route('login') }}"
                           class="btn btn-primary"
                           style="margin-right:10px" 
                       >
                           Log in
                       </a>
                         </li>
                         @if (Route::has('register'))
                         <li class="nav-item">
                           <a
                           href="{{ route('register') }}"
                           class="btn btn-success">
                           Register
                       </a>
                         </li>
                         @endif
                      
                        @endauth
                           
                        @endif
                       
                       
                      </ul>
                   </div>
                </nav>
             </div>
          </div>
       </div>
    </div>
 </header>