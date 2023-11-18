<?php
// session_start();
// // Nếu đã đăng nhập rồi thì chuyển về index
// if ( isset($_SESSION['user_email']) )
//     {
//         header('location:index.php');
//     }

function authenticateLogin($user_email, $user_password)
{
    // Thực hiện kết nối CSDL
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'qlyrap';
    $port = "3390";

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Lỗi kết nối CSDL: " . $conn->connect_error);
    }

    // Truy vấn CSDL để xác thực đăng nhập
    $stmt = $conn->prepare("SELECT * FROM thanh_vien WHERE Email = ? AND MatKhau = ?");
    $stmt->bind_param("ss", $user_email, $user_password);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = null;

    if ($result->num_rows > 0) {
        // Lấy ra phần tử đầu tiên  và return 
        $data = $result->fetch_assoc();

        $ma_thanh_vien = $data['Ma_thanh_vien'];
        $ten_thanh_vien = $data['HoTen'];

        // Thời gian sống của cookie: 7 ngày
        $sevenDays = time() + (7 * 24 * 60 * 60);

        // Đặt cookie chứa dữ liệu JSON
        setcookie("maThanhVien", $ma_thanh_vien, $sevenDays, "/");
        setcookie("tenThanhVien", $ten_thanh_vien, $sevenDays, "/");

        header('Location: index.html');
    } else {
        echo '<p class="error-message">Đăng nhập không thành công. Vui lòng kiểm tra lại email và mật khẩu.</p>';
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['login'])) {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    authenticateLogin($user_email, $user_password);
}

?>


<!doctype html>
<html>

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title>AMovie - Login</title>
    <meta name="description" content="A Template by Gozha.net">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Gozha.net">

    <!-- Mobile Specific Metas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">

    <!-- Fonts -->
    <!-- Font awesome - icon font -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <!-- Roboto -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

    <!-- Stylesheets -->

    <!-- Mobile menu -->
    <link href="css/gozha-nav.css" rel="stylesheet" />
    <!-- Select -->
    <link href="css/external/jquery.selectbox.css" rel="stylesheet" />

    <!-- Custom -->
    <link href="css/style.css?v=1" rel="stylesheet" />

    <!-- Modernizr -->
    <script src="js/external/modernizr.custom.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> 
        <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script> 
        <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>		
    <![endif]-->


    <style>
        .error-message {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- Header section -->
        <header class="header-wrapper">
            <div class="container">
                <!-- Logo link-->
                <a href='index.html' class="logo">
                    <img alt='logo' src="images/logo.png">
                </a>

                <!-- Main website navigation-->
                <nav id="navigation-box">
                    <!-- Toggle for mobile menu mode -->
                    <a href="#" id="navigation-toggle">
                        <span class="menu-icon">
                            <span class="icon-toggle" role="button" aria-label="Toggle Navigation">
                                <span class="lines"></span>
                            </span>
                        </span>
                    </a>

                    <!-- Link navigation -->
                    <ul id="navigation">
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="#">Pages</a>
                            <ul>
                                <li class="menu__nav-item"><a href="movie-page-left.html">Single movie (rigth
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="movie-page-right.html">Single movie (left
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="movie-page-full.html">Single movie (full widht)</a>
                                </li>
                                <li class="menu__nav-item"><a href="movie-list-left.html">Movies list (rigth
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="movie-list-right.html">Movies list (left
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="movie-list-full.html">Movies list (full widht)</a>
                                </li>
                                <li class="menu__nav-item"><a href="single-cinema.html">Single cinema</a></li>
                                <li class="menu__nav-item"><a href="cinema-list.html">Cinemas list</a></li>
                                <li class="menu__nav-item"><a href="trailer.html">Trailers</a></li>
                                <li class="menu__nav-item"><a href="rates-left.html">Rates (rigth sidebar)</a></li>
                                <li class="menu__nav-item"><a href="rates-right.html">Rates (left sidebar)</a></li>
                                <li class="menu__nav-item"><a href="rates-full.html">Rates (full widht)</a></li>
                                <li class="menu__nav-item"><a href="offers.html">Offers</a></li>
                                <li class="menu__nav-item"><a href="contact.html">Contact us</a></li>
                                <li class="menu__nav-item"><a href="404.html">404 error</a></li>
                                <li class="menu__nav-item"><a href="coming-soon.html">Coming soon</a></li>
                                <li class="menu__nav-item"><a href="login.html">Login/Registration</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="page-elements.html">Features</a>
                            <ul>
                                <li class="menu__nav-item"><a href="typography.html">Typography</a></li>
                                <li class="menu__nav-item"><a href="page-elements.html">Shortcodes</a></li>
                                <li class="menu__nav-item"><a href="column.html">Columns</a></li>
                                <li class="menu__nav-item"><a href="icon-font.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="page-elements.html">Booking steps</a>
                            <ul>
                                <li class="menu__nav-item"><a href="book1.html">Booking step 1</a></li>
                                <li class="menu__nav-item"><a href="book2.html">Booking step 2</a></li>
                                <li class="menu__nav-item"><a href="book3-buy.html">Booking step 3 (buy)</a></li>
                                <li class="menu__nav-item"><a href="book3-reserve.html">Booking step 3 (reserve)</a>
                                </li>
                                <li class="menu__nav-item"><a href="book-final.html">Final ticket view</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="gallery-four.html">Gallery</a>
                            <ul>
                                <li class="menu__nav-item"><a href="gallery-four.html">4 col gallery</a></li>
                                <li class="menu__nav-item"><a href="gallery-three.html">3 col gallery</a></li>
                                <li class="menu__nav-item"><a href="gallery-two.html">2 col gallery</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="news-left.html">News</a>
                            <ul>
                                <li class="menu__nav-item"><a href="news-left.html">News (rigth sidebar)</a></li>
                                <li class="menu__nav-item"><a href="news-right.html">News (left sidebar)</a></li>
                                <li class="menu__nav-item"><a href="news-full.html">News (full widht)</a></li>
                                <li class="menu__nav-item"><a href="single-page-left.html">Single post (rigth
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="single-page-right.html">Single post (left
                                        sidebar)</a></li>
                                <li class="menu__nav-item"><a href="single-page-full.html">Single post (full widht)</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span class="sub-nav-toggle plus"></span>
                            <a href="#">Mega menu</a>
                            <ul class="mega-menu container">
                                <li class="col-md-3 mega-menu__coloum">
                                    <h4 class="mega-menu__heading">Now in the cinema</h4>
                                    <ul class="mega-menu__list">
                                        <li class="mega-menu__nav-item"><a href="#">The Counselor</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Bad Grandpa</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Blue Is the Warmest Color</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Capital</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Spinning Plates</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Bastards</a></li>
                                    </ul>
                                </li>

                                <li class="col-md-3 mega-menu__coloum mega-menu__coloum--outheading">
                                    <ul class="mega-menu__list">
                                        <li class="mega-menu__nav-item"><a href="#">Gravity</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Captain Phillips</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Carrie</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Cloudy with a Chance of Meatballs
                                                2</a></li>
                                    </ul>
                                </li>

                                <li class="col-md-3 mega-menu__coloum">
                                    <h4 class="mega-menu__heading">Ending soon</h4>
                                    <ul class="mega-menu__list">
                                        <li class="mega-menu__nav-item"><a href="#">Escape Plan</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Rush</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Prisoners</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Enough Said</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">The Fifth Estate</a></li>
                                        <li class="mega-menu__nav-item"><a href="#">Runner Runner</a></li>
                                    </ul>
                                </li>

                                <li class="col-md-3 mega-menu__coloum mega-menu__coloum--outheading">
                                    <ul class="mega-menu__list">
                                        <li class="mega-menu__nav-item"><a href="#">Insidious: Chapter 2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <!-- Additional header buttons / Auth and direct link to booking-->
                <div class="control-panel">
                    <!-- <a href="#" class="btn btn--sign">Sign in</a> -->
                    <a href="#" class="btn btn-md btn--warning btn--book">Book a ticket</a>
                </div>

            </div>
        </header>

        <!-- Search bar -->
        <!-- <div class="search-wrapper">
            <div class="container container--add">
                <form id='search-form' method='get' class="search">
                    <input type="text" class="search__field" placeholder="Search">
                    <select name="sorting_item" id="search-sort" class="search__sort" tabindex="0">
                        <option value="1" selected='selected'>By title</option>
                        <option value="2">By year</option>
                        <option value="3">By producer</option>
                        <option value="4">By title</option>
                        <option value="5">By year</option>
                    </select>
                    <button type='submit' class="btn btn-md btn--danger search__button">search a movie</button>
                </form>
            </div>
        </div> -->

        <!-- Main content -->

        <form id="login-form" class="login" method='post' action="login.php">
            <p class="login__title">sign in <br><span class="login-edition">welcome to A.Movie</span></p>

            <!-- <div class="social social--colored">
                            <a href='#' class="social__variant fa fa-facebook"></a>
                            <a href='#' class="social__variant fa fa-twitter"></a>
                            <a href='#' class="social__variant fa fa-tumblr"></a>
                    </div>

                    <p class="login__tracker">or</p> -->

            <div class="field-wrap">
                <input type='email' placeholder='Email' name='user_email' class="login__input">
                <input type='password' placeholder='Password' name='user_password' class="login__input">

                <input type='checkbox' id='#informed' class='login__check styled'>
                <label for='#informed' class='login__check-info'>remember me</label>
            </div>

            <div class="login__control">
                <button type='submit' name="login" class="btn btn-md btn--warning btn--wider">sign in</button>
                <a href="#" class="login__tracker form__tracker">Forgot password?</a>
            </div>

        </form>
        <div class="clearfix"></div>
    </div>

    <footer class="footer-wrapper footer-wrapper--mod">
        <section class="container">
            <div class="col-xs-4 col-md-2 footer-nav">
                <ul class="nav-link">
                    <li><a href="#" class="nav-link__item">Cities</a></li>
                    <li><a href="movie-list-left.html" class="nav-link__item">Movies</a></li>
                    <li><a href="trailer.html" class="nav-link__item">Trailers</a></li>
                    <li><a href="rates-left.html" class="nav-link__item">Rates</a></li>
                </ul>
            </div>
            <div class="col-xs-4 col-md-2 footer-nav">
                <ul class="nav-link">
                    <li><a href="coming-soon.html" class="nav-link__item">Coming soon</a></li>
                    <li><a href="cinema-list.html" class="nav-link__item">Cinemas</a></li>
                    <li><a href="offers.html" class="nav-link__item">Best offers</a></li>
                    <li><a href="news-left.html" class="nav-link__item">News</a></li>
                </ul>
            </div>
            <div class="col-xs-4 col-md-2 footer-nav">
                <ul class="nav-link">
                    <li><a href="#" class="nav-link__item">Terms of use</a></li>
                    <li><a href="gallery-four.html" class="nav-link__item">Gallery</a></li>
                    <li><a href="contact.html" class="nav-link__item">Contacts</a></li>
                    <li><a href="page-elements.html" class="nav-link__item">Shortcodes</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="footer-info">
                    <p class="heading-special--small">A.Movie<br><span class="title-edition">in the social media</span>
                    </p>

                    <div class="social">
                        <a href='#' class="social__variant fa fa-facebook"></a>
                        <a href='#' class="social__variant fa fa-twitter"></a>
                        <a href='#' class="social__variant fa fa-vk"></a>
                        <a href='#' class="social__variant fa fa-instagram"></a>
                        <a href='#' class="social__variant fa fa-tumblr"></a>
                        <a href='#' class="social__variant fa fa-pinterest"></a>
                    </div>

                    <div class="clearfix"></div>
                    <p class="copy">&copy; A.Movie, 2013. All rights reserved. Done by Olia Gozha</p>
                </div>
            </div>
        </section>
    </footer>

    <!-- JavaScript-->
    <!-- jQuery 1.9.1-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/external/jquery-1.10.1.min.js"><\/script>')</script>
    <!-- Migrate -->
    <script src="js/external/jquery-migrate-1.2.1.min.js"></script>
    <!-- Bootstrap 3-->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

    <!-- Mobile menu -->
    <script src="js/jquery.mobile.menu.js"></script>
    <!-- Select -->
    <script src="js/external/jquery.selectbox-0.2.min.js"></script>
    <!-- Form element -->
    <script src="js/external/form-element.js"></script>
    <!-- Form validation -->


    <!-- Custom -->
    <script src="js/custom.js"></script>

</body>

</html>