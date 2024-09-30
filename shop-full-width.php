<?php
// Include database connection
include('db_connect.php');

// Query to get all products
$query = "SELECT proizvodi.id_proizvoda, proizvodi.naziv, proizvodi.cena_bez_popusta, proizvodi.cena_sa_popustom, slike.url_slike
          FROM proizvodi
          LEFT JOIN slike ON proizvodi.id_proizvoda = slike.id_proizvoda
          GROUP BY proizvodi.id_proizvoda";  // Assuming you want one image per product

$result = $conn->query($query);

$sql = "SELECT COUNT(*) AS total_products FROM proizvodi";
$res = $conn->query($sql);

// Fetch the result
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ecommerce, market, shop, mart, cart, deal, multipurpose, marketplace">
    <meta name="description" content="Svi proizvodi - Tvoj luksuz">
    <meta name="author" content="milosmitrovic20">
    <title>Svi proizvodi - Tvoj luksuz</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/img/logo/favicon.png">

    <!-- Icon CSS -->
    <link rel="stylesheet" href="assets/css/vendor/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor/remixicon.css">

    <!-- Vendor -->
    <link rel="stylesheet" href="assets/css/vendor/animate.css">
    <link rel="stylesheet" href="assets/css/vendor/aos.min.css">
    <link rel="stylesheet" href="assets/css/vendor/range-slider.css">
    <link rel="stylesheet" href="assets/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/vendor/jquery.slick.css">
    <link rel="stylesheet" href="assets/css/vendor/slick-theme.css">

    <!-- Tailwind CSS -->
    <script src="assets/js/vendor/tailwindcss3.4.5.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay" class="w-full h-full fixed top-[0] right-[0] left-[0] bottom-[0] bg-[#fff] flex items-center justify-center z-[99]">
        <span class="loader w-[10px] h-[10px] rounded-[50%] inline-block relative text-[#64b496] left-[-100px]"></span>
    </div>

     <!-- Header -->
     <header class="h-[142px] max-[991px]:h-[133px] max-[575px]:h-[173px] bg-[#fff] border-b-[1px] border-solid border-[#e9e9e9]">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="top-header py-[20px] flex flex-row gap-[10px] justify-between border-b-[1px] border-solid border-[#e9e9e9] relative z-[4] max-[575px]:py-[15px] max-[575px]:block">
                        <a href="index.html" class="cr-logo max-[575px]:mb-[15px] max-[575px]:flex max-[575px]:justify-center">
                            <img src="assets/img/logo/logo.png" alt="logo" class="logo block h-[35px] max-[575px]:w-[100px]">
                        </a>
                        <form class="cr-search relative max-[575px]:max-w-[350px] max-[575px]:m-auto">
                            <input class="search-input w-[600px] h-[45px] pl-[15px] pr-[175px] border-[1px] border-solid border-[#64b496] rounded-[5px] outline-[0] max-[1399px]:w-[400px] max-[991px]:max-w-[350px] max-[575px]:w-full max-[420px]:pr-[45px]" type="text" placeholder="Pretraži sajt">
                            <a href="javascript:void(0)" class="search-btn w-[45px] bg-[#64b496] absolute right-[0] top-[0] bottom-[0] rounded-r-[5px] flex items-center justify-center">
                                <i class="ri-search-line text-[14px] text-[#fff]"></i>
                            </a>
                        </form>
                        <div class="cr-right-bar flex max-[991px]:hidden">
                            <a href="cart.html" class="cr-right-bar-item transition-all duration-[0.3s] ease-in-out flex items-center">
                                <i class="ri-shopping-bag-line pr-[5px] text-[21px] leading-[17px]"></i>
                                <span class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[15px] leading-[15px] font-medium text-[#000]">Korpa</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cr-fix" id="cr-main-menu-desk">
            <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
                <div class="cr-menu-list w-full px-[12px] relative flex items-center flex-row justify-between">
                    <div class="cr-category-icon-block py-[10px] max-[991px]:hidden">
                        <div class="cr-category-menu relative">
                            <div class="cr-category-toggle w-[35px] h-[35px] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] cursor-pointer flex items-center justify-center">
                                <i class="ri-menu-2-line text-[22px] text-[#2b2b2d] leading-[14px] block"></i>
                            </div>
                        </div>
                    </div>
                    <nav class="justify-between relative flex flex-wrap items-center max-[991px]:w-full max-[991px]:py-[10px]">
                        <a href="javascript:void(0)" class="navbar-toggler py-[7px] px-[14px] hidden text-[16px] leading-[1] max-[991px]:flex max-[991px]:p-[0] max-[991px]:border-[0]">
                            <i class="ri-menu-3-line max-[991px]:text-[20px]"></i>
                        </a>
                        <div class="min-[992px]:flex min-[992px]:basis-auto grow-[1] items-center hidden" id="navbarSupportedContent">
                            <ul class="navbar-nav flex min-[992px]:flex-row items-center m-auto relative z-[3] min-[992px]:flex-row max-[1199px]:mr-[-5px] max-[991px]:m-[0]">
                                <li class="nav-item relative mr-[25px] max-[1399px]:mr-[20px] max-[1199px]:mr-[30px]">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="index.html">
                                        Početna
                                    </a>
                                </li>
                                <li class="nav-item relative mr-[25px] max-[1399px]:mr-[20px] max-[1199px]:mr-[30px]">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="shop-full-width.php">
                                        Proizvodi
                                    </a>
                                </li>
                                <li class="nav-item relative">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="contact-us.html">
                                        Kontakt
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="cr-calling flex justify-end items-center max-[1199px]:hidden">
                        <i class="ri-phone-line pr-[5px] text-[20px]"></i>
                        <a href="javascript:void(0)" class="text-[15px] font-medium">+381 64 8221 993</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile menu -->
    <div class="cr-sidebar-overlay w-full h-screen hidden fixed top-[0] left-[0] bg-[#000000b3] z-[21]"></div>
    <div id="cr_mobile_menu" class="cr-side-cart cr-mobile-menu transition-all duration-[0.5s] ease h-full p-[15px] fixed top-[0] bg-[#fff] z-[22] overflow-auto w-[400px] left-[-400px] max-[575px]:w-[300px] max-[575px]:left-[-300px] max-[420px]:w-[250px] max-[420px]:left-[-250px]">
        <div class="cr-menu-title w-full mb-[10px] pb-[10px] flex flex-wrap justify-between border-b-[2px] border-solid border-[#e9e9e9]">
            <span class="menu-title text-[18px] font-semibold text-[#64b496]">Meni</span>
            <button type="button" class="cr-close relative border-[0] text-[30px] leading-[1] text-[#999] bg-[#fff]">×</button>
        </div>
        <div class="cr-menu-inner">
            <div class="cr-menu-content">
                <ul>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="index.html" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Početna</a>
                    </li>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="shop-full-width.php" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Proizvodi</a>
                    </li>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="contact-us.html" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Kontakt</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Shop -->
    <section class="section-shop py-[50px] max-[1199px]:py-[20px]">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                    <div class="flex flex-wrap w-full">
                        <div class="w-full px-[12px]">
                            <div class="cr-shop-bredekamp mb-[30px] flex flex-wrap items-center bg-[#f7f7f8] border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                                <div class="cr-toggle m-[5px] flex">
                                    <a href="javascript:void(0)" class="gridCol h-[35px] w-[35px] flex justify-center items-center mr-[7px] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] max-[360px]:mr-[7px] active-grid">
                                        <i class="ri-grid-line text-[20px]"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="gridRow h-[35px] w-[35px] flex justify-center items-center bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                                        <i class="ri-list-check-2 text-[20px]"></i>
                                    </a>
                                </div>
                                <div class="center-content flex justify-start items-center flex-[1]">
                                    <span class="px-[12px] font-Poppins text-[14px] leading-[1.875] text-[#7a7a7a] max-[767px]:hidden">Pronašli smo <?php echo $row['total_products']; ?> proizvoda za tebe!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap col-50 mb-[-24px]">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="min-[992px]:w-[25%] w-[50%] max-[480px]:w-full px-[12px] cr-product-box mb-[24px]">
                                <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                    <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                        <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                            <img src="<?php echo $row['url_slike']; ?>" alt="<?php echo $row['naziv']; ?>" class="w-full rounded-[5px]">
                                        </div>
                                        <div class="cr-side-view transition-all duration-[0.4s] ease-in-out absolute z-[20] top-[15px] right-[-40px] grid opacity-0 max-[991px]:right-[12px]">
                                            <a href="javascript:void(0)" class="wishlist h-[35px] w-[35px] flex items-center justify-center m-0 p-0 bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[100%]">
                                                <i class="ri-heart-line text-[18px] leading-[10px]"></i>
                                            </a>
                                        </div>
                                        <a class="cr-shopping-bag h-[35px] w-[35px] absolute bottom-[-16px] flex items-center justify-center m-0 p-0 bg-[#f7f7f8] border-[1px] border-solid border-[#e9e9e9] rounded-[100%]" href="javascript:void(0)">
                                            <i class="ri-shopping-bag-line text-[#64b496]"></i>
                                        </a>
                                    </div>
                                    <div class="cr-product-details pt-[24px] text-center overflow-hidden max-[1199px]:pt-[20px]">
                                        <div class="cr-brand">
                                            <div class="cr-star mb-[12px] flex justify-center items-center">
                                                <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                                <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                                <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                                <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                                <i class="ri-star-line mx-[1px] text-[15px] text-[#f5885f]"></i>
                                                <p class="mb-[0] font-Poppins ml-[5px] text-[#999] text-[11px] leading-[10px]">(4.5)</p>
                                            </div>
                                        </div>
                                        <a href="product-full-width.php?id=<?php echo $row['id_proizvoda']; ?>" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center"><?php echo $row['naziv']; ?></a>
                                        <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                            <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]"><?php echo $row['cena_sa_popustom']; ?> RSD</span> 
                                            <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]"><?php echo $row['cena_bez_popusta']; ?> RSD</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>                             
                    </div>
                    <nav aria-label="..." class="cr-pagination mt-[24px] flex justify-center w-full">
                        <ul class="pagination flex text-[1rem] border-[1px] border-solid border-[#eee] rounded-[10px]">
                            <li class="page-item disabled px-[0.75rem] py-[0.375rem] bg-[#f7f7f8] rounded-l-[10px] border-r-[1px] border-solid border-[#eee] hover:bg-[#f7f7f8]">
                                <span class="page-link">Prethodna</span>
                            </li>
                            <li class="page-item px-[0.75rem] py-[0.375rem] border-r-[1px] border-solid border-[#eee] hover:bg-[#f7f7f8] active" aria-current="page">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item px-[0.75rem] py-[0.375rem] border-r-[1px] border-solid border-[#eee] hover:bg-[#f7f7f8]"><a class="page-link" href="#">2</a></li>
                            <li class="page-item px-[0.75rem] py-[0.375rem] border-r-[1px] border-solid border-[#eee] hover:bg-[#f7f7f8]"><a class="page-link" href="#">3</a></li>
                            <li class="page-item px-[0.75rem] py-[0.375rem] rounded-r-[10px] hover:bg-[#f7f7f8]"><a class="page-link" href="#">Sledeća</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer pt-[100px] max-[1199px]:pt-[70px] bg-off-white bg-[#f7f7f8] relative border-t-[1px] border-solid border-[#e9e9e9]">
        <div class="footer-container flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full footer-top pb-[100px] max-[1199px]:pb-[70px]">
                <div class="min-[1200px]:w-[33.33%] min-[992px]:w-[50%] min-[576px]:w-full w-full px-[12px] cr-footer-border">
                    <div class="cr-footer-logo max-w-[400px] mb-[15px] pb-[0]">
                        <div class="image pb-[15px]">
                            <img src="assets/img/logo/logo.png" alt="logo" class="logo w-[100px] block">
                            <img src="assets/img/logo/dark-logo.png" alt="logo" class="dark-logo w-[100px] hidden">
                        </div>
                        <p class="font-Poppins text-[14px] text-[#7a7a7a] mb-[0] leading-[1.75]">Popularni proizvodi iz celog sveta kakve niste videli do sada!</p>
                    </div>
                    <div class="cr-footer">
                        <h4 class="cr-sub-title cr-title-hidden relative hidden max-[991px]:block font-Manrope text-[18px] max-[991px]:text-[15px] font-bold leading-[1.3] text-[#000] mb-[15px] max-[991px]:py-[15px] max-[991px]:mb-[0] max-[991px]:border-b-[1px] max-[991px]:border-solid max-[991px]:border-[#e9e9e9]">
                            Kontaktiraj nas
                            <span class="cr-heading-res hidden"></span>
                        </h4>
                        <ul class="cr-footer-links max-[991px]:hidden cr-footer-dropdown max-[1199px]:max-w-[500px] max-[991px]:mt-[24px]">
                            <li class="mail-icon mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative pl-[30px] max-[1399px]:mt-[20px] max-[991px]:mt-[15px]">
                                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">prodaja@tvojluksuz.rs</a>
                            </li>
                            <li class="phone-icon font-Poppins text-[14px] leading-[26px] text-[#777] relative pl-[30px] mb-[0] max-[1399px]:mt-[20px] max-[991px]:mt-[15px]">
                                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">+381 64 8221 993</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="min-[1200px]:w-[16.66%] min-[992px]:w-[25%] min-[576px]:w-full w-full px-[12px] cr-footer-border">
                    <div class="cr-footer">
                        <h4 class="cr-sub-title font-Manrope relative text-[18px] font-bold leading-[1.3] text-[#000] mb-[15px] max-[991px]:py-[15px] max-[991px]:mb-[0] max-[991px]:text-[15px] max-[991px]:border-b-[1px] max-[991px]:border-solid max-[991px]:border-[#e9e9e9]">
                            Ostale stranice
                            <span class="cr-heading-res hidden"></span>
                        </h4>
                        <ul class="cr-footer-links max-[991px]:hidden cr-footer-dropdown max-[991px]:mt-[24px]">
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px]"><a href="track-order.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Dostava i plaćanje</a></li>
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px]"><a href="policy.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Politika privatnosti</a></li>
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px]"><a href="terms.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Uslovi korišćenja</a></li>
                        </ul>
                    </div>
                </div>
                <div class="min-[1200px]:w-[16.66%] min-[992px]:w-[25%] min-[576px]:w-full w-full px-[12px] cr-footer-border">
                    <div class="cr-footer">
                        <h4 class="cr-sub-title font-Manrope relative text-[18px] font-bold leading-[1.3] text-[#000] mb-[15px] max-[991px]:py-[15px] max-[991px]:mb-[0] max-[991px]:text-[15px] max-[991px]:border-b-[1px] max-[991px]:border-solid max-[991px]:border-[#e9e9e9]">
                            Kategorije
                            <span class="cr-heading-res hidden"></span>
                        </h4>
                        <ul class="cr-footer-links max-[991px]:hidden cr-footer-dropdown max-[991px]:mt-[24px]">
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px] max-[991px]:mt-[-5px]"><a href="shop-left-sidebar.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Domaćinstvo</a></li>
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px]"><a href="shop-left-sidebar.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Elektronski uređaji</a></li>
                            <li class="mb-[12px] font-Poppins text-[14px] leading-[26px] text-[#777] relative max-[991px]:my-[12px]"><a href="shop-left-sidebar.html" class="transition-all duration-[0.3s] ease-in-out relative font-Poppins text-[14px] leading-[26px] text-[#777] hover:text-[#64b496]">Rasveta za dvorište</a></li>
                        </ul>
                    </div>
                </div>
                <div class="min-[1200px]:w-[33.33%] min-[992px]:w-full w-full px-[12px] cr-footer-border">
                    <div class="cr-footer cr-newsletter max-[1199px]:mt-[50px] max-[1199px]:pt-[50px] max-[1199px]:border-t-[1px] max-[1199px]:border-solid max-[1199px]:border-[#e1dfdf] max-[991px]:mt-[0] max-[991px]:pt-[0] max-[991px]:border-[0]">
                        <h4 class="cr-sub-title font-Manrope relative text-[18px] font-bold leading-[1.3] text-[#000] mb-[15px] max-[991px]:py-[15px] max-[991px]:mb-[0] max-[991px]:text-[15px] max-[991px]:border-b-[1px] max-[991px]:border-solid max-[991px]:border-[#e9e9e9]">
                            Prijavi se na našu mejl listu
                            <span class="cr-heading-res hidden"></span>
                        </h4>
                        <div class="cr-footer-links max-[991px]:hidden cr-footer-dropdown max-[1199px]:max-w-[500px] max-[991px]:mt-[24px]">
                            <form class="cr-search-footer relative">
                                <input class="search-input w-full h-[44px] py-[5px] px-[15px] border-[1px] border-solid border-[#e9e9e9] outline-[0] rounded-[5px]" type="text" placeholder="Unesi mejl adresu">
                                <a href="javascript:void(0)" class="search-btn w-[50px] absolute right-[0] top-[0] bottom-[0] flex items-center justify-center">
                                    <i class="ri-send-plane-fill text-[21px] text-[#000]"></i>
                                </a>
                            </form>
                        </div>
                        <div class="cr-social-media my-[22px] mx-[-2px] flex flex-row max-[991px]:mt-[40px] max-[991px]:mr-[0] max-[991px]:mb-[24px] max-[991px]:ml-[0] max-[991px]:flex-wrap">
                            <span class="m-[2px] font-Poppins text-[17px] font-normal leading-[1.625] text-[#000]"><a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] flex items-center justify-center leading-[11px] bg-[#fff] border-[1px] border-solid border-[#e1dfdf] rounded-[5px] text-[#000] hover:text-[#64b496]"><i class="ri-facebook-line"></i></a></span>
                            <span class="m-[2px] font-Poppins text-[17px] font-normal leading-[1.625] text-[#000]"><a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] flex items-center justify-center leading-[11px] bg-[#fff] border-[1px] border-solid border-[#e1dfdf] rounded-[5px] text-[#000] hover:text-[#64b496]"><i class="ri-twitter-x-line"></i></a></span>
                            <span class="m-[2px] font-Poppins text-[17px] font-normal leading-[1.625] text-[#000]"><a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] flex items-center justify-center leading-[11px] bg-[#fff] border-[1px] border-solid border-[#e1dfdf] rounded-[5px] text-[#000] hover:text-[#64b496]"><i class="ri-dribbble-line"></i></a></span>
                            <span class="m-[2px] font-Poppins text-[17px] font-normal leading-[1.625] text-[#000]"><a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] flex items-center justify-center leading-[11px] bg-[#fff] border-[1px] border-solid border-[#e1dfdf] rounded-[5px] text-[#000] hover:text-[#64b496]"><i class="ri-instagram-line"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cr-last-footer w-full py-[20px] border-t-[1px] border-solid border-[#e9e9e9] text-center">
                <p class="font-Poppins text-[14px] text-[#000] leading-[1.2] ">&copy; <span id="copyright_year"></span> <a href="index.html" class="text-[#64b496]">Tvoj luksuz</a>, Sva prava zadržana.</p>
            </div>
        </div>
    </footer>

    <!-- Tab to top -->
    <a href="#Top" class="back-to-top result-placeholder h-[38px] w-[38px] hidden fixed right-[15px] bottom-[15px] z-[10] cursor-pointer rounded-[20px] bg-[#fff] text-[#64b496] border-[1px] border-solid border-[#64b496] text-center text-[22px] leading-[1.6] hover:transition-all hover:duration-[0.3s] hover:ease-in-out">
        <i class="ri-arrow-up-line text-[20px]"></i>
        <div class="back-to-top-wrap">
            <svg viewBox="-1 -1 102 102" class="w-[36px] h-[36px] fixed right-[16px] bottom-[16px]">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" class="fill-transparent stroke-[#64b496] stroke-[5px]" />
            </svg>
        </div>
    </a>

    <!-- Quick View Model -->
    <div class="cr-modal-overlay w-full h-screen hidden fixed top-0 left-0 z-[10] bg-[#000000b3]"></div>
    <div class="cr-modal max-[575px]:w-full fixed top-[50%] left-[50%] z-[30] max-[767px]:w-full hidden max-[767px]:max-h-full max-[767px]:overflow-y-auto">
        <div class="cr-modal-dialog h-full my-[0%] mx-auto max-w-[900px] w-[900px] max-[991px]:max-w-[650px] max-[991px]:w-[650px] max-[767px]:h-auto max-[767px]:m-[0] max-[767px]:py-[35px] max-[767px]:mx-auto max-[575px]:w-[90%] transition-transform duration-[0.3s] ease-out cr-fadeOutUp">
            <div class="modal-content p-[30px] relative bg-[#fff] rounded-[5px]">
                <div class="cr-close-modal absolute top-[10px] right-[10px] leading-[18px]">
                    <i class="ri-close-line text-[18px] font-extrabold text-[#ca4141] cursor-pointer"></i>
                </div>
                <div class="modal-body mx-[-12px] max-[767px]:mx-[0]">
                    <div class="w-full flex flex-wrap w-full">
                        <div class="min-[768px]:w-[41.66%] px-[12px] max-[767px]:px-[0] w-full">
                            <div class="zoom-image-hover modal-border-image border-[1px] border-solid border-[#e9e9e9] h-full flex items-center text-center bg-[#f7f7f8] rounded-[5px] crosshair">
                                <img src="assets/img/product/tab-1.jpg" alt="product-tab-2" class="product-image w-full block m-auto">
                            </div>
                        </div>
                        <div class="min-[768px]:w-[58.33%] px-[12px] max-[767px]:px-[0] w-full">
                            <div class="cr-size-and-weight-contain border-b-[1px] border-solid border-[#e9e9e9] pb-[20px] max-[767px]:mt-[24px]">
                                <h2 class="heading mb-[15px] block text-[#2b2b2d] text-[22px] leading-[1.5] font-medium max-[1399px]:text-[26px] max-[991px]:text-[20px]">Peach Seeds Of Change Oraganic Quinoa, Brown fruit</h2>
                                <p class="mb-[0] font-Poppins text-[#7a7a7a] text-[14px] leading-[1.75]">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                    since the 1900s,</p>
                            </div>
                            <div class="cr-size-and-weight pt-[20px]">
                                <div class="cr-review-star flex">
                                    <div class="cr-star mr-[10px]">
                                        <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                        <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                        <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                        <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                        <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                    </div>
                                    <p class="mb-[0] text-[15px] font-Poppins text-[#7a7a7a] leading-[1.75] max-[380px]:hidden">( 75 Review )</p>
                                </div>
                                <div class="cr-product-price pt-[20px]">
                                    <span class="new-price font-Poppins text-[24px] font-semibold leading-[1.167] text-[#64b496] max-[767px]:text-[22px] max-[575px]:text-[20px]">$120.25</span>
                                    <span class="old-price font-Poppins text-[16px] line-through leading-[1.75] text-[#7a7a7a]">$123.25</span>
                                </div>
                                <div class="cr-size-weight flex items-center pt-[20px] max-[380px]:flex-col max-[380px]:justify-start max-[380px]:items-start">
                                    <h5 class="font-Poppins mb-[0] text-[16px] leading-[1.556] text-[#2b2b2d] max-[1199px]:min-w-[100px] max-[1199px]:text-[14px]"><span>Size</span>/<span>Weight</span> :</h5>
                                    <div class="cr-kg pl-[10px] max-[380px]:pl-[0] max-[380px]:pt-[10px]">
                                        <ul class="w-full p-[0] m-[0] flex flex-wrap">
                                            <li class="transition-all duration-[0.3s] ease-in-out m-[2px] py-[5px] px-[10px] font-Poppins text-[12px] leading-[1] bg-[#fff] text-[#777] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] cursor-pointer max-[1199px]:mr-[5px] active-color">500gm</li>
                                            <li class="transition-all duration-[0.3s] ease-in-out m-[2px] py-[5px] px-[10px] font-Poppins text-[12px] leading-[1] bg-[#fff] text-[#777] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] cursor-pointer max-[1199px]:mr-[5px]">1kg</li>
                                            <li class="transition-all duration-[0.3s] ease-in-out m-[2px] py-[5px] px-[10px] font-Poppins text-[12px] leading-[1] bg-[#fff] text-[#777] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] cursor-pointer max-[1199px]:mr-[5px]">2kg</li>
                                            <li class="transition-all duration-[0.3s] ease-in-out m-[2px] py-[5px] px-[10px] font-Poppins text-[12px] leading-[1] bg-[#fff] text-[#777] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] cursor-pointer max-[1199px]:mr-[5px]">5kg</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cr-add-card flex pt-[20px]">
                                    <div class="cr-qty-main h-full flex relative">
                                        <input type="text" placeholder="." value="1" minlength="1" maxlength="20"
                                            class="quantity h-[40px] w-[40px] mr-[5px] text-center border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                                        <button type="button" id="add_model" class="plus h-[18px] w-[18px] p-[0] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] leading-[0]">+</button>
                                        <button type="button" id="sub_model" class="minus h-[18px] w-[18px] p-[0] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] leading-[0] absolute bottom-[0] right-[0]">-</button>
                                    </div>
                                    <div class="cr-add-button ml-[15px]">
                                        <button type="button" class="cr-button h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] max-[380px]:text-[13px] text-[14px] font-Manrope capitalize leading-[1.2] bg-[#64b496] text-[#fff] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:bg-[#000] hover:border-[#000] max-[1199px]:py-[8px] max-[1199px]:px-[15px]">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Vendor Custom -->
    <script src="assets/js/vendor/jquery-3.6.4.min.js"></script>
    <script src="assets/js/vendor/jquery.zoom.min.js"></script>
    <script src="assets/js/vendor/mixitup.min.js"></script>
    <script src="assets/js/vendor/range-slider.js"></script>
    <script src="assets/js/vendor/aos.min.js"></script>
    <script src="assets/js/vendor/swiper-bundle.min.js"></script>
    <script src="assets/js/vendor/slick.min.js"></script>

    <!-- Main Custom -->
    <script src="assets/js/main.js"></script>
    
</body>

</html>