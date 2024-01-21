 <style>
     .ytPreview {
         margin-top: 15px;
     }

     .ytPreview .Polaris-LegacyCard {
         width: 100%;
         padding: 15px;
     }

     .ytPreview .Polaris-MediaCard__MediaContainer {
         width: 30%;
         max-width: 30%;
     }

     .ytPreview .Polaris-VideoThumbnail__ThumbnailContainer {
         text-align: center;
         width: 100%;
     }

     .ytPreview .Polaris-MediaCard__InfoContainer:not(.Polaris-MediaCard--portrait) {
         flex-basis: 70%;
     }

     .previewHeading {
         font-size: 30px;
     }

     .previewSubHeading {
         font-size: 15px;
         margin-top: 8px;
         font-weight: 400;
     }
 </style>
 <?php
    if ($ytGallery[0]['linkType'] == '2') {
        $dbYtData = array(
            'id' => $ytGallery[0]['videoId'],
            'PublishedAt' => $ytGallery[0]['publishedAt'],
            'title' => $ytGallery[0]['videoTitle'],
            'desc' => $ytGallery[0]['videoDescription'],
            'url' => $ytGallery[0]['videoUrl'],
            'thumbDefault' => $ytGallery[0]['videoThumbnailDefault'],
            'thumbMedium' => $ytGallery[0]['videoThumbnailMedium'],
            'thumbHigh' => $ytGallery[0]['videoThumbnailHigh'],
            'views' => $ytGallery[0]['videoViews'],
            'likes' => $ytGallery[0]['videoLikeCount'],
            'comments' => $ytGallery[0]['videoCommentCount']
        );
    } else {
        $dbYtData = array(
            'id' => $ytGallery[0]['channelId'],
            'PublishedAt' => '',
            'title' => $ytGallery[0]['channelTitle'],
            'desc' => $ytGallery[0]['channelDescription'],
            'url' => $ytGallery[0]['channelCustomUrl'],
            'thumbDefault' => $ytGallery[0]['channelThumbnailDefault'],
            'thumbMedium' => $ytGallery[0]['channelThumbnailMedium'],
            'thumbHigh' => $ytGallery[0]['channelThumbnailHigh'],
            'views' => $ytGallery[0]['channelViews'],
            'subscribers' => $ytGallery[0]['channelSubscriberCount'],
            'videos' => $ytGallery[0]['channelVideoCount']
        );
    }

    ?>
 <div class="Polaris-LegacyStack__Item">
     <h1 class="Polaris-Header-Title" style="text-align: left;
">YouTube Gallery</h3>
 </div>

 <div class="pageWrapper">
     <div class="callOutOffer">
         <div class="Polaris-LegacyCard">
             <div class="Polaris-CalloutCard__Container">
                 <div class="Polaris-LegacyCard__Section">
                     <div class="Polaris-CalloutCard">
                         <div class="Polaris-CalloutCard__Content">
                             <form method="post">
                                 <div class="Polaris-FormLayout">
                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <h2 class="Polaris-Text--root Polaris-Text--headingMd">Step 1. Add YouTube content</h2>
                                         </div>

                                         <div class="Polaris-Connected">
                                             <div style="display: inline-flex;">
                                                 <label class="Polaris-Choice Polaris-RadioButton__ChoiceLabel" for="linkType1">
                                                     <span class="Polaris-Choice__Control">
                                                         <span class="Polaris-RadioButton">
                                                             <input id="linkType1" name="linkType" <?php echo $ytGallery[0]['linkType'] == '1' ? 'checked' : ''; ?> type="radio" class="Polaris-RadioButton__Input linkType" aria-describedby="disabledHelpText" value="1">
                                                             <span class="Polaris-RadioButton__Backdrop">
                                                             </span>
                                                         </span>
                                                     </span>
                                                     <span class="Polaris-Choice__Label">
                                                         <span>Youtube Channel</span>
                                                     </span>
                                                 </label>
                                                 <div class="Polaris-LegacyStack__Item">
                                                     <label class="Polaris-Choice Polaris-RadioButton__ChoiceLabel" style="margin-left: 15px;" for="linkType2">
                                                         <span class="Polaris-Choice__Control">
                                                             <span class="Polaris-RadioButton">
                                                                 <input id="linkType2" name="linkType" <?php echo $ytGallery[0]['linkType'] == '2' ? 'checked' : ''; ?> type="radio" class="Polaris-RadioButton__Input linkType" aria-describedby="disabledHelpText" value="2">
                                                                 <span class="Polaris-RadioButton__Backdrop">
                                                                 </span>
                                                             </span>
                                                         </span>
                                                         <span class="Polaris-Choice__Label">
                                                             <span>Youtube Video</span>
                                                         </span>
                                                     </label>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary" style="display: inline-flex;">
                                                 <div class="Polaris-TextField" style="width: 100%;">
                                                     <input id="ytLink" placeholder="YouTube link (video, channel, playlist, shorts)" autocomplete="off" class="Polaris-TextField__Input" type="text" aria-describedby=":ra:HelpText" aria-labelledby=":ra:Label" aria-invalid="false" value="<?php echo $ytGallery[0]['youtubeLink']; ?>" style="padding-top:9px;">
                                                     <div class="Polaris-TextField__Backdrop"></div>
                                                 </div>
                                                 <div class="Polaris-LegacyStack__Item" style="padding-left: 15px;">
                                                     <button class="Polaris-Button Polaris-Button--primary step1Addbtn" aria-disabled="false" type="button">
                                                         <span class="Polaris-Button__Content">
                                                             <span class="Polaris-Button__Text">Add</span>
                                                         </span>
                                                     </button>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Connected ytPreview">
                                             <div class="Polaris-LegacyCard">
                                                 <div class="Polaris-MediaCard">
                                                     <div class="Polaris-MediaCard__MediaContainer">
                                                         <div class="Polaris-VideoThumbnail__ThumbnailContainer">
                                                             <div class="Polaris-VideoThumbnail__Thumbnail" style="background-image:url(<?php echo $dbYtData['thumbMedium']; ?>);text-align: center;">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="Polaris-MediaCard__InfoContainer">
                                                         <div class="Polaris-LegacyCard__Section">

                                                             <div class="Polaris-LegacyStack Polaris-LegacyStack--vertical Polaris-LegacyStack--spacingTight">
                                                                 <div class="Polaris-LegacyStack__Item">
                                                                     <div class="Polaris-MediaCard__Heading">

                                                                         <h2 class="Polaris-Text--root Polaris-Text--headingMd previewHeading"><?php echo $dbYtData['title'] ?></h2>
                                                                         <?php
                                                                            if ($ytGallery[0]['linkType'] == '1') { ?>
                                                                             <span class="previewSubHeading Channel">
                                                                                 <span class="channelCustomUrl"><?php echo $dbYtData['url'] ?></span>
                                                                                 <span class="channelSubscriberCount"> <?php echo $dbYtData['subscribers'] . " "; ?>subscriber</span>
                                                                                 <span class="channelVideoCount"> <?php echo $dbYtData['videos'] . " "; ?> videos</span>
                                                                             </span>
                                                                         <?php } else { ?>
                                                                             <span class="previewSubHeading Video">
                                                                                 <span class="videoViews"><?php echo $dbYtData['views'] . " "; ?>Views</span>
                                                                                 <span class="videoLikeCount"> <?php echo $dbYtData['likes'] . " "; ?>Likes</span>
                                                                                 <span class="videoCommentCount"> <?php echo $dbYtData['comments'] . " "; ?> Comments</span>
                                                                             </span>
                                                                         <?php } ?>
                                                                         </h2>
                                                                     </div>
                                                                 </div>
                                                                 <div class="Polaris-LegacyStack__Item">
                                                                     <p class="Polaris-MediaCard__Description previewDescription"><?php echo $dbYtData['desc'] ?></p>
                                                                 </div>
                                                                 <div class="Polaris-LegacyStack__Item">
                                                                     <div class="Polaris-MediaCard__ActionContainer">

                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="ytLinkError error"></div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <h2 class="Polaris-Text--root Polaris-Text--headingMd">Step 3. Select Page</h2>
                                         </div>
                                         <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary" style="display: inline-flex;">
                                                 <div class="Polaris-LegacyStack Polaris-LegacyStack--vertical radioOption">
                                                     <div class="Polaris-LegacyStack__Item">
                                                         <div>
                                                             <label class="Polaris-Choice Polaris-RadioButton__ChoiceLabel" for="selectPage1">
                                                                 <span class="Polaris-Choice__Control">
                                                                     <span class="Polaris-RadioButton">
                                                                         <input id="selectPage1" name="selectPage" <?php echo $ytGallery[0]['page'] == '1' ? 'checked' : ''; ?> type="radio" class="Polaris-RadioButton__Input selectPage" aria-describedby="disabledHelpText" value="1">
                                                                         <span class="Polaris-RadioButton__Backdrop">
                                                                         </span>
                                                                     </span>
                                                                 </span>
                                                                 <span class="Polaris-Choice__Label">
                                                                     <span>Homepage</span>
                                                                 </span>
                                                             </label>
                                                         </div>
                                                     </div>
                                                     <div class="Polaris-LegacyStack__Item">
                                                         <div>
                                                             <label class="Polaris-Choice Polaris-RadioButton__ChoiceLabel" for="selectPage2">
                                                                 <span class="Polaris-Choice__Control">
                                                                     <span class="Polaris-RadioButton">
                                                                         <input id="selectPage2" name="selectPage" type="radio" <?php echo $ytGallery[0]['page'] == '2' ? 'checked' : ''; ?> class="Polaris-RadioButton__Input selectPage" aria-describedby="disabledHelpText" value="2">
                                                                         <span class="Polaris-RadioButton__Backdrop">
                                                                         </span>
                                                                     </span>
                                                                 </span>
                                                                 <span class="Polaris-Choice__Label">
                                                                     <span>Product</span>
                                                                 </span>
                                                             </label>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Connected selectProductDiv">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary" style="display: inline-flex;">
                                                 <button class="Polaris-Button selectProduct" id="selectProduct" type="button">
                                                     <span class="Polaris-Button__Content">
                                                         <span class="Polaris-Button__Text">Add product</span>
                                                     </span>
                                                 </button>
                                             </div>
                                         </div>

                                         <div class="selectPageError error"></div>

                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <button class="Polaris-Button Polaris-Button--primary" type="button" id="submitYtGallery">
                                             <span class="Polaris-Button__Content">
                                                 <span class="Polaris-Button__Text">Save</span>
                                             </span>
                                         </button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <input type="hidden" id="tempId">
 <input type="hidden" id="usdCurrencyRate" value="<?php echo $usdCurrencyRate; ?>">
 <input type="hidden" id="totalChargeINR" value="">
 <input type="hidden" id="selectProductVal">


 <script type="text/javascript">
     $(document).ready(function() {

         function showYtPreview() {
             if (!$(".selectPage").is(":checked")) {
                 shopify.toast.show('Please Select Youtube Channel Or Youtube video');
                 return false;
             }

             if ($('#ytLink').val() == '') {
                 if ($('.linkType:checked').val() == '1') {
                     shopify.toast.show('Please enter valid channel Id or channel Link');
                 } else {
                     shopify.toast.show('Please enter valid  youtube video link');
                 }
                 return false;
             }

             $('.ytPreview').show();
         }

         showYtPreview();
         $('.step1Addbtn').on('click', function() {
             showYtPreview();

             var data = {};
             data.action = 'getYtLinkPreview';
             data.linkType = $('.linkType:checked').val();
             data.ytLink = $('#ytLink').val();

             $.ajax({
                 url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                 type: "post",
                 data: data,
                 success: function(response) {
                     var res = JSON.parse(response);
                     var title = '';
                     var desc = '';
                     if ($('.linkType:checked').val() == '1') {
                         title = res.channelTitle;
                         desc = res.channelDescription;
                     } else {
                         title = res.videoTitle;
                         desc = res.videoDescription;
                     }
                     desc = desc.length > 400 ? desc.substr(0, desc.lastIndexOf(' ', 399)) + '...' : desc;
                     $('.previewHeading').text(title);
                     $('.previewDescription').text(desc);

                     //  shopify.toast.show('YouTube Gallery Saved');
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
             });

         });

         <?php if ($ytGallery[0]['page'] == '1') { ?> $('.selectProductDiv').hide();
         <?php } else { ?> $('.selectProductDiv').show();
         <?php } ?> $('.selectPage').on('change', function() {
             if ($(this).val() == '1') {
                 $('.selectProductDiv').hide();
                 $(this).prop("checked", true);
                 $('#selectProductVal').val('');

             } else {
                 $('.selectProductDiv').show();
                 $(this).prop("checked", true);

             }
         });

         $('#submitYtGallery').on('click', function() {
             if ($('#ytLink').val() == '') {
                 $('.ytLinkError').text('Please enter valid link');
                 return false;
             } else {
                 $('.ytLinkError').text('');
             }

             if ($(".selectPage").is(":checked")) {
                 if ($('.selectPage:checked').val() == '2') {
                     if ($('#selectProductVal').val() == '') {
                         $('.selectPageError').text('Please Select Product');
                         return false;
                     } else {
                         $('.selectPageError').text('');
                     }
                 } else {
                     $('.selectPageError').text('');
                 }
             } else {
                 $('.selectPageError').text('');
                 $('.selectPageError').text('Please Select Page');
                 return false;
             }

             var data = {};
             data.action = 'submitYtGallery';
             data.linkType = $('.linkType:checked').val();
             data.ytLink = $('#ytLink').val();
             data.selectPage = $('.selectPage:checked').val();
             data.selectProduct = $('#selectProductVal').val();

             $.ajax({
                 url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                 type: "post",
                 data: data,
                 success: function(response) {
                     shopify.toast.show('YouTube Gallery Saved');
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
             });

         });
     });

     document.getElementById('selectProduct').addEventListener('click', async () => {
         const selected = await shopify.resourcePicker({
             type: 'product'
         });
         var str = selected[0]['id'];
         str = str.substring(str.indexOf("/Product/") + 1);
         str = str.substring(str.indexOf("/") + 1);
         $('#selectProductVal').val(str);
     });
 </script>