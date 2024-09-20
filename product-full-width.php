<?php
// Include database connection file
include('db_connect.php'); 

// Assuming you pass the product ID through a GET parameter
$productId = isset($_GET['id']) ? intval($_GET['id']) : 4; 

// SQL query to fetch product details and images
$query = "SELECT proizvodi.*, slike.url_slike 
          FROM proizvodi 
          LEFT JOIN slike ON proizvodi.id_proizvoda = slike.id_proizvoda 
          WHERE proizvodi.id_proizvoda = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

$product = [];
$images = [];

while ($row = $result->fetch_assoc()) {
    if (empty($product)) {
        // Store product details once
        $product = [
            'title' => $row['naziv'],
            'price' => $row['cena_bez_popusta'],
            'discounted_price' => $row['cena_sa_popustom'],
            'short_description' => $row['kratki_opis'],
            'description' => $row['opis']
        ];
    }
    // Store each image
    $images[] = $row['url_slike'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ecommerce, market, shop, mart, cart, deal, multipurpose, marketplace">
    <meta name="description" content="SunShade - Zaštita od sunca za šoferšajbnu — Tvoj luksuz">
    <meta name="author" content="milosmitrovic20">
    <title>SunShade - Zaštita od sunca za šoferšajbnu — Tvoj luksuz</title>

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
                            <img src="assets/img/logo/dark-logo.png" alt="logo" class="dark-logo hidden h-[35px] w-[115px] max-[575px]:w-[100px]">
                        </a>
                        <form class="cr-search relative max-[575px]:max-w-[350px] max-[575px]:m-auto">
                            <input class="search-input w-[600px] h-[45px] pl-[15px] pr-[175px] border-[1px] border-solid border-[#64b496] rounded-[5px] outline-[0] max-[1399px]:w-[400px] max-[991px]:max-w-[350px] max-[575px]:w-full max-[420px]:pr-[45px]" type="text" placeholder="Pretraži sajt">
                            <select class="form-select mr-[10px] w-[120px] h-[calc(100%-2px)] border-[0] tracking-[0] absolute top-[1px] pt-[0.375rem] pb-[0.375rem] pl-[0.5rem] outline-[0] right-[45px] text-[13px] border-l-[1px] border-solid border-[#64b496] rounded-[0] max-[420px]:hidden" aria-label="Default select example">
                                <option selected>Sve kategorije</option>
                                <option value="1">Domaćinstvo</option>
                                <option value="2">Sve za kuhinju</option>
                                <option value="3">Elektronski uređaji</option>
                            </select>
                            <a href="javascript:void(0)" class="search-btn w-[45px] bg-[#64b496] absolute right-[0] top-[0] bottom-[0] rounded-r-[5px] flex items-center justify-center">
                                <i class="ri-search-line text-[14px] text-[#fff]"></i>
                            </a>
                        </form>
                        <div class="cr-right-bar flex max-[991px]:hidden">
                            <a href="wishlist.html" class="cr-right-bar-item pr-[30px] transition-all duration-[0.3s] ease-in-out flex items-center">
                                <i class="ri-heart-3-line pr-[5px] text-[21px] leading-[17px]"></i>
                                <span class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[15px] leading-[15px] font-medium text-[#000]">Omiljeno</span>
                            </a>
                            <a href="javascript:void(0)" class="cr-right-bar-item Shopping-toggle transition-all duration-[0.3s] ease-in-out flex items-center">
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
                        <div class="cr-header-buttons hidden max-[991px]:flex max-[991px]:items-center">
                            <ul class="navbar-nav relative z-[3] m-auto max-[1199px]:mr-[-5px] max-[991px]:m-[0] flex flex-col">
                                <li class="nav-item dropdown relative">
                                    <ul class="dropdown-menu transition-all duration-[0.3s] ease-in-out py-[8px] min-w-[160px] mt-[35px] absolute text-left opacity-0 invisible left-auto right-0 bg-[#fff] rounded-[5px] block z-[9] border-[1px] border-solid border-[#e9e9e9]">
                                        <li class="w-full">
                                            <a class="dropdown-item transition-all duration-[0.3s] ease-in-out w-full block py-[7px] px-[20px] bg-[#fff] relative capitalize text-[13px] text-[#777]" href="register.html">Registracija</a>
                                        </li>
                                        <li class="w-full">
                                            <a class="dropdown-item transition-all duration-[0.3s] ease-in-out w-full block py-[7px] px-[20px] bg-[#fff] relative capitalize text-[13px] text-[#777]" href="checkout.html">Plaćanje</a>
                                        </li>
                                        <li class="w-full">
                                            <a class="dropdown-item transition-all duration-[0.3s] ease-in-out w-full block py-[7px] px-[20px] bg-[#fff] relative capitalize text-[13px] text-[#777]" href="login.html">Prijava</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <a href="wishlist.html" class="cr-right-bar-item transition-all duration-[0.3s] ease-in-out mr-[16px] max-[991px]:mr-[20px]">
                                <i class="ri-heart-line text-[20px]"></i>
                            </a>
                            <a href="javascript:void(0)" class="cr-right-bar-item Shopping-toggle transition-all duration-[0.3s] ease-in-out mr-[16px] max-[991px]:m-[0]">
                                <i class="ri-shopping-cart-line text-[20px]"></i>
                            </a>
                        </div>
                        <div class="min-[992px]:flex min-[992px]:basis-auto grow-[1] items-center hidden" id="navbarSupportedContent">
                            <ul class="navbar-nav flex min-[992px]:flex-row items-center m-auto relative z-[3] min-[992px]:flex-row max-[1199px]:mr-[-5px] max-[991px]:m-[0]">
                                <li class="nav-item relative mr-[25px] max-[1399px]:mr-[20px] max-[1199px]:mr-[30px]">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="javascript:void(0)">
                                        Početna
                                    </a>
                                </li>
                                <li class="nav-item relative mr-[25px] max-[1399px]:mr-[20px] max-[1199px]:mr-[30px]">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="javascript:void(0)">
                                        Kategorije
                                    </a>
                                </li>
                                <li class="nav-item relative mr-[25px] max-[1399px]:mr-[20px] max-[1199px]:mr-[30px]">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="javascript:void(0)">
                                        Proizvodi
                                    </a>
                                </li>
                                <li class="nav-item relative">
                                    <a class="nav-link font-Poppins text-[14px] font-medium block text-[#000] z-[1] flex items-center relative py-[11px] px-[8px] max-[1199px]:py-[8px] max-[1199px]:px-[0]" href="javascript:void(0)">
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
                        <a href="javascript:void(0)" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Početna</a>
                    </li>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="javascript:void(0)" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Kategorije</a>
                    </li>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="javascript:void(0)" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Proizvodi</a>
                    </li>
                    <li class="dropdown drop-list relative leading-[28px]">
                        <a href="javascript:void(0)" class="dropdown-list py-[12px] block capitalize text-[15px] font-medium text-[#444] border-b-[1px] border-solid border-[#e9e9e9]">Kontakt</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Product -->
    <section class="section-product pt-[50px] max-[1199px]:pt-[20px]">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full mb-[-24px]" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                <div class="min-[1400px]:w-[33.33%] min-[1200px]:w-[41.66%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px]">
                    <div class="vehicle-detail-banner banner-content clearfix h-full">
                        <div class="banner-slider sticky top-[30px]">
                            <div class="slider slider-for mb-[15px]">
                                <?php foreach ($images as $image_url): ?>
                                    <div class="slider-banner-image">
                                        <div class="zoom-image-hover h-full flex items-center text-center border-[1px] border-solid border-[#e9e9e9] bg-[#f7f7f8] rounded-[5px] cursor-pointer">
                                            <img src="<?php echo $image_url; ?>" alt="Product Image" class="product-image w-full block m-auto">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="slider slider-nav thumb-image mx-[-6px]">
                                <?php foreach ($images as $image_url): ?>
                                    <div class="thumbnail-image">
                                        <div class="thumbImg mx-[6px] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] flex justify-center items-center">
                                            <img src="<?php echo $image_url; ?>" alt="Thumbnail Image" class="w-full p-[2px] rounded-[5px]">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="min-[1400px]:w-[66.66%] min-[1200px]:w-[58.33%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px]">
                    <div class="cr-size-and-weight-contain border-b-[1px] border-solid border-[#e9e9e9] pb-[20px] max-[767px]:mt-[24px]">
                        <h2 class="heading mb-[15px] block text-[#2b2b2d] text-[22px] leading-[1.5] font-medium max-[1399px]:text-[26px] max-[991px]:text-[20px]"><?php echo $product['title']; ?></h2>
                        <p class="mb-[0] text-[14px] font-Poppins text-[#7a7a7a] leading-[1.75] "><?php echo $product['short_description']; ?></p>
                    </div>
                    <div class="cr-size-and-weight pt-[20px]">
                        <div class="cr-review-star flex">
                            <div class="cr-star mr-[10px]">
                                <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                <i class="ri-star-fill text-[16px] text-[#f5885f]"></i>
                                <i class="ri-star-line text-[16px] text-[#f5885f]"></i>
                            </div>
                            <p class="mb-[0] text-[15px] font-Poppins text-[#7a7a7a] leading-[1.75] max-[380px]:hidden">( 2 recenzije )</p>
                        </div>
                        <div class="list">
                            <ul class="mt-[15px] p-[0] mb-[1rem]">
                                <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Dimenzije <span>:</span></label>135 x 75 cm</li>
                                <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Boja zadnje strane <span>:</span></label>Crna</li>
                                <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Boja prednje strane <span>:</span></label>Srebrna</li>
                                <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Materijal <span>:</span></label>Metal i izdržljivo platno</li>
                            </ul>
                        </div>
                        <div class="cr-product-price pt-[20px]">
                            <span class="new-price font-Poppins text-[24px] font-semibold leading-[1.167] text-[#64b496] max-[767px]:text-[22px] max-[575px]:text-[20px]"><?php echo $product['discounted_price']; ?> RSD</span>
                            <span class="old-price font-Poppins text-[16px] line-through leading-[1.75] text-[#7a7a7a]"><?php echo $product['price']; ?> RSD</span>
                        </div>
                        <div class="cr-add-card flex pt-[20px]">
                            <div class="cr-qty-main h-full flex relative">
                                <input type="text" placeholder="." value="1" minlength="1" maxlength="20" class="quantity h-[40px] w-[40px] mr-[5px] text-center border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                                <button type="button" class="plus w-[18px] h-[18px] p-[0] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] leading-[0]">+</button>
                                <button type="button" class="minus w-[18px] h-[18px] p-[0] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] leading-[0] absolute bottom-[0] right-[0]">-</button>
                            </div>
                            <div class="cr-add-button ml-[15px] max-[380px]:hidden">
                                <button type="button" class="cr-button cr-shopping-bag h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] text-[14px] font-Manrope leading-[1.2] bg-[#64b496] text-[#fff] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:bg-[#000] hover:border-[#000] max-[1199px]:py-[8px] max-[1199px]:px-[15px]">Dodaj u korpu</button>
                            </div>
                            <div class="cr-card-icon flex ml-[15px]">
                                <a href="javascript:void(0)" class="wishlist m-[0] p-[0] bg-transparent">
                                    <i class="ri-heart-line transition-all duration-[0.3s] ease-in-out h-[40px] w-[40px] mr-[10px] flex items-center justify-center text-[22px] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] hover:bg-[#64b496] hover:text-[#fff]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap w-full" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                <div class="w-full px-[12px]">
                    <div class="cr-paking-delivery mt-[40px] p-[24px] bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                        <ul class="nav nav-tabs border-b-[1px] border-solid border-[#dee2e6] flex flex-wrap justify-left" id="mydeliveryTab">
                            <li class="nav-item transition-all duration-[0.3s] ease-in-out mr-[30px] relative active">
                                <a href="#description" class="mb-[25px] flex font-Poppins text-[17px] font-semibold leading-[1.5] tracking-[0] text-[#2b2b2d] text-left max-[1399px]:text-[18px] max-[767px]:text-[16px] max-[575px]:mb-[15px]">Opis</a>
                            </li>
                            <li class="nav-item transition-all duration-[0.3s] mr-[30px] relative ease-in-out">
                                <a href="#additional" class="mb-[25px] flex font-Poppins text-[17px] font-semibold leading-[1.5] tracking-[0] text-[#2b2b2d] text-left max-[1399px]:text-[18px] max-[767px]:text-[16px] max-[575px]:mb-[15px]">Informacije</a>
                            </li>
                            <li class="nav-item transition-all duration-[0.3s] mr-[30px] relative ease-in-out">
                                <a href="#review" class="mb-[25px] flex font-Poppins text-[17px] font-semibold leading-[1.5] tracking-[0] text-[#2b2b2d] text-left max-[1399px]:text-[18px] max-[767px]:text-[16px] max-[575px]:mb-[15px]">Recenzije</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-delivery-pane" id="description">
                                <div class="cr-tab-content">
                                    <div class="cr-description pt-[30px]">
                                        <p class="text-[14px] text-left mb-[0] font-Poppins text-[#7a7a7a] leading-[1.75]"><?php echo $product['description']; ?></p>
                                    </div>
                                    <h4 class="heading mb-[0] pt-[30px] pb-[20px] font-Poppins text-[16px] font-medium leading-[1.5] text-left text-[#2b2b2d] border-b-[1px] border-solid border-[#e9e9e9]">Pakovanje i dostava</h4>
                                    <div class="cr-description pt-[30px]">
                                        <p class="text-[14px] text-left mb-[0] font-Poppins text-[#7a7a7a] leading-[1.75]">Dostava za 2-3 radna dana. Cena dostave je 280 dinara, a za porudžbine preko 2.000 dinara dostava je besplatna.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-delivery-pane" id="additional">
                                <div class="cr-tab-content">
                                    <div class="cr-description pt-[30px]">
                                        <p class="text-[14px] text-left mb-[0] font-Poppins text-[#7a7a7a] leading-[1.75]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Error in vero
                                            sapiente doloribus debitis corporis, eaque dicta, repellat amet, illum adipisci vel
                                            perferendis dolor! Quis vel consequuntur repellat distinctio rem. Corrupti
                                            ratione alias odio, error dolore temporibus consequatur, nobis veniam odit
                                            laborum dignissimos consectetur quae vero in perferendis provident quis.</p>
                                    </div>
                                    <div class="list">
                                        <ul class="mt-[30px] mb-[-5px] p-[0]">
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Brand <span>:</span></label>ESTA BETTERU CO</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Flavour <span>:</span></label>Super Saver Pack</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Diet Type <span>:</span></label>Vegetarian</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Weight <span>:</span></label>200 Grams</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Speciality <span>:</span></label>Gluten Free, Sugar Free</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Info <span>:</span></label>Egg Free, Allergen-Free</li>
                                            <li class="py-[5px] text-[#777] flex"><label class="min-w-[100px] mr-[10px] text-[#2b2b2d] font-semibold flex justify-between">Items <span>:</span></label>1</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-delivery-pane" id="review">
                                <div class="cr-tab-content-from pt-[30px]">
                                    <div class="post mb-[30px]">
                                        <div class="content flex max-[575px]:flex-col">
                                            <img src="assets/img/review/1.jpg" alt="review" class="h-[50px] w-[50px] mr-[24px] rounded-[5px] max-[575px]:mb-[24px]">
                                            <div class="details flex flex-col">
                                                <span class="date mb-[10px] text-[13px] text-[#777]">Jan 08, 2024</span>
                                                <span class="name mb-[10px] font-medium text-[17px]">Vuk Ristić</span>
                                            </div>
                                            <div class="cr-t-review-rating ml-auto mb-[20px] max-[575px]:ml-[0] max-[575px]:mb-[24px]">
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                            </div>
                                        </div>
                                        <p class="m-[0] font-Poppins text-[14px] text-[#7a7a7a] leading-[1.75] pl-[74px] max-[575px]:p-[0]">Ova zaštita od sunca za šoferšajbnu je apsolutni must-have za svakog vozača! Veoma je jednostavna za postavljanje i pokriva celu šoferšajbnu, pružajući potpunu zaštitu od sunčevih zraka. Primetio sam da je temperatura u automobilu znatno niža kada koristim ovu zaštitu, što čini vožnju mnogo prijatnijom, posebno tokom vrelih letnjih dana. Materijal je kvalitetan i izdržljiv, a dizajn je dovoljno kompaktan da se lako sklapa i odlaže kada nije u upotrebi. Definitivno preporučujem svima koji žele da zaštite svoj automobil od sunca!</p>
                                        <div class="content mt-[30px] flex max-[575px]:flex-col">
                                            <img src="assets/img/review/2.jpg" alt="review" class="h-[50px] w-[50px] mr-[24px] rounded-[5px] max-[575px]:mb-[24px]">
                                            <div class="details flex flex-col">
                                                <span class="date mb-[10px] text-[13px] text-[#777]">Mar 22, 2024</span>
                                                <span class="name mb-[10px] font-medium text-[17px]">Mateja Mitrović</span>
                                            </div>
                                            <div class="cr-t-review-rating ml-auto mb-[20px] max-[575px]:ml-[0] max-[575px]:mb-[24px]">
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-line text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                            </div>
                                        </div>
                                        <p class="m-[0] font-Poppins text-[14px] text-[#7a7a7a] leading-[1.75] pl-[74px] max-[575px]:p-[0]">Prezadovoljan sam ovom zaštitom od sunca za šoferšajbnu! Ne samo da efektivno blokira sunce i održava unutrašnjost automobila hladnijom, već je i vrlo jednostavna za korišćenje. Samo je raširim preko šoferšajbne i obezbedim uz pomoć retrovizora. Uklanjanje je podjednako lako, i kad je ne koristim, sklapa se u mali paket koji ne zauzima mnogo prostora u kolima. Materijal deluje kvalitetno i verujem da će dugo trajati. Ovo je definitivno proizvod koji bih preporučio svim vozačima!</p>
                                    </div>
                                    <h4 class="heading font-Poppins text-[16px] font-medium leading-[1.5] text-[#2b2b2d] pb-[10px] mb-[0.5rem] ">Dodaj recenziju</h4>
                                    <form action="javascript:void(0)">
                                        <div class="cr-ratting-star flex">
                                            <span class="font-Poppins text-[14px] text-[#7a7a7a] leading-[1.75] mr-[10px]">Tvoja ocena :</span>
                                            <div class="cr-t-review-rating mb-[20px]">
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-fill text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-line text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-line text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                                <i class="ri-star-s-line text-[19px] text-[#f5885f] tracking-[-5px]"></i>
                                            </div>
                                        </div>
                                        <div class="cr-ratting-input mb-[10px]">
                                            <input name="your-name" placeholder="Ime" type="text" class="w-full h-[50px] py-[5px] px-[20px] outline-[0] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] twxt-[#777] text-[14px]">
                                        </div>
                                        <div class="cr-ratting-input mb-[10px]">
                                            <input name="your-email" placeholder="Email*" type="email" required class="w-full h-[50px] py-[5px] px-[20px] outline-[0] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] twxt-[#777] text-[14px]">
                                        </div>
                                        <div class="cr-ratting-input form-submit">
                                            <textarea name="your-commemt" placeholder="Komentar" class="w-full h-[150px] mb-[15px] p-[20px] bg-transparent text-[14px] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] text-[#777] outline-[0]"></textarea>
                                            <button class="cr-button h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] text-[14px] font-Manrope capitalize leading-[1.2] bg-[#64b496] text-[#fff] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:bg-[#000] hover:border-[#000]" type="submit" value="Submit">Pošalji</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular products -->
    <section class="section-popular-products py-[100px] max-[1199px]:py-[70px]" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1600px]:max-w-[1500px] min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="mb-[30px]">
                        <div class="cr-banner mb-[15px] text-center">
                            <h2 class="font-Manrope text-[32px] font-bold leading-[1.2] text-[#2b2b2d] max-[1199px]:text-[28px] max-[991px]:text-[25px] max-[767px]:text-[22px]">Popularni proizvodi</h2>
                        </div>
                        <div class="cr-banner-sub-title w-full">
                            <p class="max-w-[600px] m-auto font-Poppins text-[14px] text-[#212529] leading-[22px] text-center max-[1199px]:w-[80%] max-[991px]:w-full font-Poppins text-[#7a7a7a]">Izdvojili smo neke od najtraženijih proizvoda na tržištu. Otkrij najbolje od ponude, pažljivo odabrano kako bismo pružili vrhunski kvalitet, pouzdanost i vrednost.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap w-full">
                <div class="w-full">
                    <div class="cr-popular-product">
                        <div class="slick-slide">
                            <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                    <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                        <img src="assets/img/product/sealock.png" alt="product-1" class="w-full rounded-[5px]">
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
                                    <a href="product-left-sidebar.html" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">SeaLock - Sef za plažu</a>
                                    <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                        <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">1,690 RSD</span> 
                                        <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">4,990 RSD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                    <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                        <img src="assets/img/product/hydrorelax.png" alt="product-1" class="w-full rounded-[5px]">
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
                                            <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                            <p class="mb-[0] font-Poppins ml-[5px] text-[#999] text-[11px] leading-[10px]">(5.0)</p>
                                        </div>
                                    </div>
                                    <a href="product-left-sidebar.html" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">HydroRelax - Podesiva glava tuša</a>
                                    <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                        <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">1,390 RSD</span> 
                                        <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">2,190 RSD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                    <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                        <img src="assets/img/product/painaway.png" alt="product-1" class="w-full rounded-[5px]">
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
                                    <a href="product-left-sidebar.html" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">PainAway - Maska za ublažavanje migrene i glavobolje</a>
                                    <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                        <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">1,390 RSD</span> 
                                        <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">2,490 RSD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                    <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                        <img src="assets/img/product/sharky.png" alt="product-1" class="w-full rounded-[5px]">
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
                                            <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                            <p class="mb-[0] font-Poppins ml-[5px] text-[#999] text-[11px] leading-[10px]">(5.0)</p>
                                        </div>
                                    </div>
                                    <a href="product-left-sidebar.html" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">Sharky papuče</a>
                                    <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                        <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">1,290 RSD</span> 
                                        <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">3,390 RSD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                                <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                                    <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                        <img src="assets/img/product/perfectwing.png" alt="product-1" class="w-full rounded-[5px]">
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
                                            <i class="ri-star-fill mx-[1px] text-[15px] text-[#f5885f]"></i>
                                            <p class="mb-[0] font-Poppins ml-[5px] text-[#999] text-[11px] leading-[10px]">(5.0)</p>
                                        </div>
                                    </div>
                                    <a href="product-left-sidebar.html" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">PerfectWing - Dvostrana vodootporna eyeliner olovka</a>
                                    <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                        <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">1,490 RSD</span> 
                                        <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">1,990 RSD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <button type="button" class="cr-button h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] max-[380px]:text-[13px] text-[14px] font-Manrope leading-[1.2] bg-[#64b496] text-[#fff] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:bg-[#000] hover:border-[#000] max-[1199px]:py-[8px] max-[1199px]:px-[15px]">Dodaj u korpu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="cr-cart-overlay w-full h-screen hidden fixed z-[10] top-[0] left-[0] bg-[#000000b3]"></div>
    <div class="cr-cart-view h-full fixed top-[0] right-[-350px] z-[20] transition-all duration-[0.4s] ease text-[#000]">
        <div class="cr-cart-inner w-[350px] h-full m-[0] px-[20px] bg-[#fff] relative z-[9] flex flex-col justify-between max-[575px]:w-[300px] max-[360px]:w-[280px]">
            <div class="cr-cart-top">
                <div class="cr-cart-title mb-[15px] py-[15px] flex flex-row justify-between items-center border-b-[1px] border-solid border-[#e9e9e9]">
                    <h6 class="m-[0] text-[17px] font-bold text-[#2b2b2d] leading-[1.2]">My Cart</h6>
                    <button type="button" class="close-cart text-[#fb5555] text-[20px] font-extrabold bg-none border-[0]">×</button>
                </div>
                <ul class="crcart-pro-items">
                    <li class="mb-[20px] pb-[20px] flex overflow-hidden border-b-[1px] border-solid border-[#e9e9e9]">
                        <a href="product-left-sidebar.html" class="crside_pro_img m-auto grow-[1] basis-[20%]">
                            <img src="assets/img/product/4.jpg" alt="product-1" class="max-w-full rounded-[5px]">
                        </a>
                        <div class="cr-pro-content pl-[15px] relative grow-[1] basis-[70%] overflow-hidden">
                            <a href="product-left-sidebar.html" class="cart_pro_title w-full pr-[30px] whitespace-normal overflow-hidden text-ellipsis block text-[15px] leading-[18px] font-normal">Fresh Pomegranate</a>
                            <span class="cart-price mt-[5px] text-[14px] block"><span class="text-[#777] font-bold text-[16px]">$56.00</span> x 1kg</span>
                            <div class="cr-cart-qty mt-[5px]">
                                <div class="cart-qty-plus-minus m-[0] w-[80px] h-[30px] relative overflow-hidden flex bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] items-center justify-between">
                                    <button type="button" class="plus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">+</button>
                                    <input type="text" placeholder="." value="1" minlength="1" maxlength="20"
                                        class="quantity w-[30px] m-[0] p-[0] text-[#444] float-left text-[14px] font-semibold leading-[38px] h-auto text-center outline-[0]">
                                    <button type="button" class="minus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">-</button>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="remove py-[0] px-[9px] absolute top-[0] right-[0] text-[17px] leading-[15px] bg-[#fff] text-[#fb5555]">×</a>
                        </div>
                    </li>
                    <li class="mb-[20px] pb-[20px] flex overflow-hidden border-b-[1px] border-solid border-[#e9e9e9]">
                        <a href="product-left-sidebar.html" class="crside_pro_img m-auto grow-[1] basis-[20%]">
                            <img src="assets/img/product/2.jpg" alt="product-2" class="max-w-full rounded-[5px]">
                        </a>
                        <div class="cr-pro-content pl-[15px] relative grow-[1] basis-[70%] overflow-hidden">
                            <a href="product-left-sidebar.html" class="cart_pro_title w-full pr-[30px] whitespace-normal overflow-hidden text-ellipsis block text-[15px] leading-[18px] font-normal">Green Apples</a>
                            <span class="cart-price mt-[5px] text-[14px] block"><span class="text-[#777] font-bold text-[16px]">$75.00</span> x 1kg</span>
                            <div class="cr-cart-qty mt-[5px]">
                                <div class="cart-qty-plus-minus m-[0] w-[80px] h-[30px] relative overflow-hidden flex bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] items-center justify-between">
                                    <button type="button" class="plus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">+</button>
                                    <input type="text" placeholder="." value="1" minlength="1" maxlength="20"
                                        class="quantity w-[30px] m-[0] p-[0] text-[#444] float-left text-[14px] font-semibold leading-[38px] h-auto text-center outline-[0]">
                                    <button type="button" class="minus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">-</button>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="remove py-[0] px-[9px] absolute top-[0] right-[0] text-[17px] leading-[15px] bg-[#fff] text-[#fb5555]">×</a>
                        </div>
                    </li>
                    <li class="mb-[20px] pb-[20px] flex overflow-hidden border-b-[1px] border-solid border-[#e9e9e9]">
                        <a href="product-left-sidebar.html" class="crside_pro_img m-auto grow-[1] basis-[20%]">
                            <img src="assets/img/product/3.jpg" alt="product-3" class="max-w-full rounded-[5px]">
                        </a>
                        <div class="cr-pro-content pl-[15px] relative grow-[1] basis-[70%] overflow-hidden">
                            <a href="product-left-sidebar.html" class="cart_pro_title w-full pr-[30px] whitespace-normal overflow-hidden text-ellipsis block text-[15px] leading-[18px] font-normal">Watermelon - Small</a>
                            <span class="cart-price mt-[5px] text-[14px] block"><span class="text-[#777] font-bold text-[16px]">$48.00</span> x 5kg</span>
                            <div class="cr-cart-qty mt-[5px]">
                                <div class="cart-qty-plus-minus m-[0] w-[80px] h-[30px] relative overflow-hidden flex bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] items-center justify-between">
                                    <button type="button" class="plus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">+</button>
                                    <input type="text" placeholder="." value="1" minlength="1" maxlength="20"
                                        class="quantity w-[30px] m-[0] p-[0] text-[#444] float-left text-[14px] font-semibold leading-[38px] h-auto text-center outline-[0]">
                                    <button type="button" class="minus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center">-</button>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="remove py-[0] px-[9px] absolute top-[0] right-[0] text-[17px] leading-[15px] bg-[#fff] text-[#fb5555]">×</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="cr-cart-bottom relative top-[-20px]">
                <div class="cart-sub-total mt-[20px] mb-[10px] pt-[0] pb-[8px] flex flex-wrap justify-between border-t-[1px] border-solid border-[#e9e9e9]">
                    <table class="table cart-table mt-[10px] w-full">
                        <tbody>
                            <tr>
                                <td class="text-left text-[16px] text-[#000] font-normal py-[7px]">Sub-Total :</td>
                                <td class="text-right text-[15px] text-[#000] font-bold py-[7px]">$300.00</td>
                            </tr>
                            <tr>
                                <td class="text-left text-[16px] text-[#000] font-normal py-[7px]">VAT (20%) :</td>
                                <td class="text-right text-[15px] text-[#000] font-bold py-[7px]">$60.00</td>
                            </tr>
                            <tr>
                                <td class="text-left text-[16px] text-[#000] font-normal py-[7px]">Total :</td>
                                <td class="text-right text-[15px] text-[#000] font-bold py-[7px]">$360.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart_btn flex justify-between">
                    <a href="cart.html" class="cr-button h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] text-[14px] font-Manrope capitalize leading-[1.2] bg-[#64b496] text-[#fff] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:bg-[#000] hover:border-[#000]">View Cart</a>
                    <a href="checkout.html" class="cr-btn-secondary h-[40px] font-bold transition-all duration-[0.3s] ease-in-out py-[8px] px-[22px] text-[14px] font-Manrope capitalize leading-[1.2] bg-[#fff] text-[#64b496] border-[1px] border-solid border-[#64b496] rounded-[5px] flex items-center justify-center hover:text-[#fff] hover:bg-[#64b496] hover:border-[#64b496]">Checkout</a>
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