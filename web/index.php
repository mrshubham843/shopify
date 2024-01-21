 <?php
    include_once("includes/constant.php");
    include_once('includes/Database.php');
    include_once("includes/common_helper.php");

    if (checkRecurringChargeIdUpdated() != true) {
        recurringApplicationCharge();
    }

    ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'https://admin.shopify.com' 'https://app-tester-001.myshopify.com'"> -->

     <!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
     <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js?apiKey=<?php echo $appApiKey; ?>"></script>

     <link rel="stylesheet" href="css/uptown.css">
     <link rel="stylesheet" href="css/custom.css?timestamp=<?php echo strtotime('now'); ?>">
     <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@11.12.0/build/esm/styles.css" />


     <script src="js/custom.js?timestamp=<?php echo strtotime('now'); ?>"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
 </head>

 <body>


     <div class="Polaris-Frame" data-polaris-layer="true">
         <div class="Polaris-Frame__ContextualSaveBar Polaris-Frame-CSSAnimation--startFade">
         </div>
         <main class="Polaris-Frame__Main" id="AppFrameMain" data-has-global-ribbon="false">
             <div class="Polaris-Frame__Content" style="display:flex">
                 <?php include_once('sidebar.php');
                    ?>
                 <div class="mainContent">
                     <div class="navView dashboardView"> <?php include_once('dashboard.php');
                                                            ?> </div>
                     <div class="navView newOrderView"> <?php include_once('newOrder.php');
                                                        ?> </div>
                     <div class="navView orderHistoryView"> <?php include_once('orderHistory.php');
                                                            ?> </div>
                     <div class="navView servicesListView"> <?php include_once('serviceList.php');
                                                            ?> </div>
                     <div class="navView youtubeGalleryView"> <?php include_once('youtubeGallery.php');
                                                                ?> </div>
                 </div>
             </div>
         </main>
     </div>

     <script type="text/javascript">
         $('.navClick').removeClass('Polaris-Navigation__Item--selected');
         $('.navClick.dashboardNav').addClass('Polaris-Navigation__Item--selected');
         $('.navView').hide();
         $('.navView.dashboardView').show();
         $('.navView.newOrderView').hide();
         $('.navView.orderHistoryView').hide();

         $('.navClick').on('click', function() {
             if ($(this).attr('role') == 'dashboard') {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.dashboardNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.dashboardView').show();
             } else if ($(this).attr('role') == 'newOrder') {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.newOrderNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.newOrderView').show();
             } else if ($(this).attr('role') == 'orderHistory') {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.orderHistoryNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.orderHistoryView').show();
             } else if ($(this).attr('role') == 'servicesList') {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.servicesListNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.servicesListView').show();
             } else if ($(this).attr('role') == 'youtubeGallery') {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.youtubeGalleryNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.youtubeGalleryView').show();
             } else {
                 $('.navClick').removeClass('Polaris-Navigation__Item--selected');
                 $('.navClick.dashboardNav').addClass('Polaris-Navigation__Item--selected');
                 $('.navView').hide();
                 $('.navView.dashboardView').show();
             }
         });
     </script>
     <footer>
         <div class="Polaris-FooterHelp">
             <div class="Polaris-FooterHelp__Text">Learn more about<!-- -->
                 <a class="Polaris-Link" href="https://help.shopify.com/manual/orders/fulfill-orders" data-polaris-unstyled="true">fulfilling orders</a>
             </div>
         </div>
     </footer>



 </body>

 </html>