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
                                             <div class="Polaris-Label">
                                                 <label id=":R19n6:Label" for=":R19n6:" class="Polaris-Label__Text">Plateform</label>
                                             </div>
                                         </div>
                                         <div class="Polaris-Select plateformDiv">
                                             <select class="Polaris-Select__Input plateform" name="plateform" id="plateform" aria-invalid="false">
                                                 <option value="0"> Select Plateform </option>

                                                 <?php if (!empty($getPlateForms) && !empty($getPlateForms)) {
                                                        foreach ($getPlateForms as $plateform) { ?>
                                                         <option value="<?php echo $plateform['plateform_id'] ?>" <?php echo $plateform['status'] == '0' ? 'disabled' : ''; ?>><?php echo $plateform['plateform_name'] ?></option>
                                                 <?php }
                                                    } ?>
                                             </select>
                                             <div class="Polaris-Select__Content" aria-hidden="true">
                                                 <span class="Polaris-Select__SelectedOption">Select Plateform</span>
                                                 <span class="Polaris-Select__Icon">
                                                     <span class="Polaris-Icon">
                                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                                         </span>
                                                         <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                             <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z">
                                                             </path>
                                                             <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z">
                                                             </path>
                                                         </svg>
                                                     </span>
                                                 </span>
                                             </div>
                                             <div class="Polaris-Select__Backdrop">
                                             </div>
                                         </div>
                                         <div class="selectPlateformError error"></div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <div class="Polaris-Label spinnerselectServicesCategoryLabel">
                                                 <label id=":R19n6:Label" for=":R19n6:" class="Polaris-Label__Text">Select Service Category</label>
                                                 <div class="spinnerselectServicesCategory" style="margin-left: 10px;">
                                                     <span class="Polaris-Spinner Polaris-Spinner--sizeLarge">
                                                         <svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                                                             <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z">
                                                             </path>
                                                         </svg>
                                                     </span>
                                                     <span role="status">
                                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">Spinner example</span>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Select selectServicesCategoryDiv">
                                             <select id="selectServicesCategory" name="selectServicesCategory" class="Polaris-Select__Input selectServicesCategory" aria-invalid="false">
                                                 <option value="0">Select Service Category</option>

                                                 <?php

                                                    if (isset($serviceLists) && !empty($serviceLists)) {
                                                        foreach ($serviceLists as $item) {
                                                    ?>
                                                         <option value="<?php echo $item['service_id']; ?>"><?php echo $item['service']; ?></option>
                                                 <?php }
                                                    }  ?>
                                             </select>
                                             <div class="Polaris-Select__Content" aria-hidden="true">
                                                 <span class="Polaris-Select__SelectedOption">Select Service Category</span>
                                                 <span class="Polaris-Select__Icon">
                                                     <span class="Polaris-Icon">
                                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                                         </span>
                                                         <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                             <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z">
                                                             </path>
                                                             <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z">
                                                             </path>
                                                         </svg>
                                                     </span>
                                                 </span>
                                             </div>
                                             <div class="Polaris-Select__Backdrop">
                                             </div>
                                         </div>
                                         <div class="selectServicesCategoryError error">
                                         </div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <div class="Polaris-Label selectServiceLabelDiv">
                                                 <label id=":R19n6:Label" for=":R19n6:" class="Polaris-Label__Text">Select Service</label>
                                                 <div class="spinnerSelectService" style="margin-left: 10px;">
                                                     <span class="Polaris-Spinner Polaris-Spinner--sizeLarge">
                                                         <svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                                                             <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z">
                                                             </path>
                                                         </svg>
                                                     </span>
                                                     <span role="status">
                                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">Spinner example</span>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Select selectServiceDiv">
                                             <select id="selectService" class="Polaris-Select__Input selectService" name="selectService" aria-invalid="false">

                                             </select>
                                             <div class="Polaris-Select__Content " aria-hidden="true">
                                                 <span class="Polaris-Select__SelectedOption">Select Service</span>
                                                 <span class="Polaris-Select__Icon">
                                                     <span class="Polaris-Icon">
                                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                                         </span>
                                                         <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                             <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z">
                                                             </path>
                                                             <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z">
                                                             </path>
                                                         </svg>
                                                     </span>
                                                 </span>
                                             </div>
                                             <div class="Polaris-Select__Backdrop">
                                             </div>
                                         </div>
                                         <div class="selectServiceError error">
                                         </div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <div class="Polaris-Label">
                                                 <label id=":R1n6:Label" for=":R1n6:" class="Polaris-Label__Text">Service Detail</label>
                                             </div>
                                         </div>
                                         <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                 <div class="Polaris-TextField Polaris-TextField--hasValue Polaris-TextField--multiline">
                                                     <textarea id=":R1n6:" disabled autocomplete="off" class="serviceDetails Polaris-TextField__Input" type="text" rows="4" aria-labelledby=":R1n6:Label" aria-invalid="false" aria-multiline="true" style="height: 106px;"></textarea>
                                                     <div class="Polaris-TextField__Backdrop">
                                                     </div>

                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <div class="Polaris-Label">
                                                 <label id=":R1n6:Label" for=":R1n6:" class="Polaris-Label__Text">Enter Link</label>
                                             </div>
                                         </div>
                                         <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                 <div class="Polaris-TextField Polaris-TextField--hasValue">
                                                     <input id="serviceLink" autocomplete="" class="Polaris-TextField__Input serviceLink" type="text" aria-describedby=":R1n6:HelpText" aria-labelledby=":R1n6:Label" aria-invalid="false" value="">
                                                     <div class="Polaris-TextField__Backdrop">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Labelled__HelpText" id=":R1n6:HelpText">
                                             <div class="serviceLinkOpen"><a href="#" target="_blank">Click here</a> to verify link.</span>
                                             </div>
                                             <div class="errorLink error"></span>
                                             </div>
                                         </div>
                                     </div>


                                     <div class=" Polaris-FormLayout__Item">
                                         <div class="Polaris-Labelled__LabelWrapper">
                                             <div class="Polaris-Label">
                                                 <label id=":R1n6:Label" for=":R1n6:" class="Polaris-Label__Text">Quantity</label>
                                             </div>
                                         </div>
                                         <div class="Polaris-Connected quantityDiv">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                 <div class="Polaris-TextField Polaris-TextField--hasValue">
                                                     <input id="quantity" min="10" max="1000" autocomplete="off" class="Polaris-TextField__Input" type="number" aria-labelledby=":R1n6:Label" aria-invalid="false" value="">
                                                     <div class="Polaris-TextField__Spinner" aria-hidden="true">
                                                         <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                                                             <div class="Polaris-TextField__SpinnerIcon">
                                                                 <span class="Polaris-Icon">
                                                                     <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                                                     </span>
                                                                     <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                         <path fill-rule="evenodd" d="M6.24 11.8a.75.75 0 0 0 1.06-.04l2.7-2.908 2.7 2.908a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0l-3.25 3.5a.75.75 0 0 0 .04 1.06Z">
                                                                         </path>
                                                                     </svg>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                         <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                                                             <div class="Polaris-TextField__SpinnerIcon">
                                                                 <span class="Polaris-Icon">
                                                                     <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                                                     </span>
                                                                     <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                         <path fill-rule="evenodd" d="M6.24 8.2a.75.75 0 0 1 1.06.04l2.7 2.908 2.7-2.908a.75.75 0 1 1 1.1 1.02l-3.25 3.5a.75.75 0 0 1-1.1 0l-3.25-3.5a.75.75 0 0 1 .04-1.06Z">
                                                                         </path>
                                                                     </svg>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="Polaris-TextField__Backdrop">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="Polaris-Labelled__HelpText" id=":R1n6:HelpText">
                                             <span class="Polaris-Text--root Polaris-Text--break Polaris-Text--subdued">Min : <span class="minLimit">10</span> </span> ,
                                             <span class="Polaris-Text--root Polaris-Text--break Polaris-Text--subdued">Max : <span class="maxLimit">1000 </span></span>
                                         </div>
                                         <div class="errorQty error">
                                         </div>
                                         <br>
                                         <div class="Polaris-Labelled__HelpText" id=":R1n6:HelpText">
                                             <span class="Polaris-Text--root Polaris-Text--break Polaris-Text--subdued">Usage Charge : <b>$<span class="chargeAmount">0</span> </b></span>
                                         </div>
                                     </div>

                                     <div class="Polaris-FormLayout__Item">
                                         <button class="Polaris-Button Polaris-Button--primary" type="button" id="submitOrder">
                                             <span class="Polaris-Button__Content">
                                                 <span class="Polaris-Button__Text">Submit Order</span>
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
 <script type="text/javascript">
     $(document).ready(function() {

         $('.spinnerselectServicesCategory').hide();
         $('.plateform').on('change', function() {
             getServiceCategory($(this).val());
         });

         $('.selectServicesCategory option').each(function() {
             if ($(this).is(':selected')) {
                 getServiceCategory($(this).val());
             }
         });

         $('.spinnerSelectService').hide();
         $('.selectServicesCategory').on('change', function() {
             getServices($(this).val());
         });

         function getServiceCategory(val) {
             if (val > 0) {
                 $('.spinnerselectServicesCategory').show();

                 $('.plateformDiv .Polaris-Select__SelectedOption').text($('.plateform option:selected').text());
                 var data = {};
                 data.action = 'getServiceCategory';
                 data['data'] = val;

                 $.ajax({
                     url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                     type: "post",
                     data: data,
                     success: function(response) {
                         response = JSON.parse(response);
                         $('.selectServicesCategory').html('');
                         $('.selectServicesCategory').html(response.options);
                         $(".selectServicesCategory").val($(".selectServicesCategory option:first").val());
                         $('.selectServicesCategoryDiv .Polaris-Select__SelectedOption').text(response.firstArray.category_name);
                         $('.spinnerselectServicesCategory').hide();
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(textStatus, errorThrown);
                         $('.spinnerselectServicesCategory').hide();
                     }
                 });
             } else {
                 $(".plateformDiv").val($(".selectServicesCategory option:first").val());
                 $(".plateformDiv .Polaris-Select__SelectedOption").text($(".plateform option:first").text());

                 $('.selectServicesCategory').html('');
                 $(".selectServicesCategory").val(0);
                 $('.selectServicesCategoryDiv .Polaris-Select__SelectedOption').text('Select Service Category');

                 $('#selectService').html('');
                 $("#selectService").val(0);
                 $('.selectServiceDiv .Polaris-Select__SelectedOption').text('Select Service');

                 $('.minLimit').text('10');
                 $('.maxLimit').text('1000');
                 $(".serviceDetails").text('');
                 $('#quantity').attr('min', '10');
                 $('#quantity').attr('max', '1000');
             }
         }

         function getServices(val) {
             if (val > 0) {


                 $('.spinnerSelectService').show();

                 $('.selectServicesCategoryDiv .Polaris-Select__SelectedOption').text($('#selectServicesCategory option:selected').text());

                 var data = {};
                 data.action = 'getServiceList';
                 data['data'] = val;

                 $.ajax({
                     url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                     type: "post",
                     data: data,
                     success: function(response) {
                         response = JSON.parse(response);
                         $('.selectService').html('');
                         $('.selectService').html(response.options);
                         $(".selectService").val($(".selectService option:first").val());
                         $('.selectServiceDiv .Polaris-Select__SelectedOption').text(response.firstArray.updated_service_name);

                         var min = $(".selectService option:selected").attr('min');
                         var max = $(".selectService option:selected").attr('max');
                         var desc = $(".selectService option:selected").attr('desc');

                         $('.minLimit').text(min);
                         $('.maxLimit').text(max);
                         $(".serviceDetails").text(desc);
                         $('#quantity').attr('min', min);
                         $('#quantity').attr('max', max);
                         $('.spinnerSelectService').hide();

                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(textStatus, errorThrown);
                         $('.spinnerSelectService').hide();
                     }
                 });
             } else {
                 $(".selectServicesCategoryDiv").val($(".selectServicesCategory option:first").val());
                 $(".selectServicesCategoryDiv .Polaris-Select__SelectedOption").text($(".selectServicesCategory option:first").text());

                 $('#selectService').html('');
                 $("#selectService").val(0);
                 $('.selectServiceDiv .Polaris-Select__SelectedOption').text('Select Service');

                 $('.minLimit').text('10');
                 $('.maxLimit').text('1000');
                 $(".serviceDetails").text('');
                 $('#quantity').attr('min', '10');
                 $('#quantity').attr('max', '1000');
             }
         }

         $(document).on('change', '.selectService', function() {
             $('.selectServiceDiv .Polaris-Select__SelectedOption').text('');
             $('.selectServiceDiv .Polaris-Select__SelectedOption').text($('.selectService option:selected').text());

             var min = $(".selectService option:selected").attr('min');
             var max = $(".selectService option:selected").attr('max');
             var desc = $(".selectService option:selected").attr('desc');

             $('.minLimit').text(min);
             $('.maxLimit').text(max);
             $(".serviceDetails").text(desc);
             $('#quantity').attr('min', min);
             $('#quantity').attr('max', max);

         });

         $('#quantity').on('change', function() {
             var usdCurrencyRate = $('#usdCurrencyRate').val();
             var min = $(".selectService option:selected").attr('min');
             var max = $(".selectService option:selected").attr('max');
             var rate = $(".selectService option:selected").attr('rate');
             var singleQtyPrice = rate / 1000;
             var qty = $('#quantity').val();

             if (parseFloat($(this).val()) > max) {
                 $(this).val(min);
                 var totalChargeINR = singleQtyPrice * min;
                 var totalChargeUSD = totalChargeINR / usdCurrencyRate;
                 $('.chargeAmount').text(totalChargeUSD.toFixed(3));
                 $('#totalChargeINR').val(totalChargeINR);
             } else if (parseFloat($(this).val()) < min) {
                 $(this).val(min);
                 var totalChargeINR = singleQtyPrice * min;
                 var totalChargeUSD = totalChargeINR / usdCurrencyRate;
                 $('.chargeAmount').text(totalChargeUSD.toFixed(3));
                 $('#totalChargeINR').val(totalChargeINR);
             } else {
                 $(this).val($('#quantity').val());
                 var totalChargeINR = singleQtyPrice * $('#quantity').val();
                 var totalChargeUSD = totalChargeINR / usdCurrencyRate;
                 $('.chargeAmount').text(totalChargeUSD.toFixed(3));
                 $('#totalChargeINR').val(totalChargeINR);
             }
         });

         $('.serviceLinkOpen').hide();
         $('#serviceLink').on('input', function() {
             if ($(this).val() != '') {
                 $('.serviceLinkOpen').show();
                 $('.serviceLinkOpen a').attr('href', $(this).val());

             } else {
                 $('.serviceLinkOpen').hide();
             }
         });


         $('#submitOrder').on('click', function() {
             if ($('#plateform').val() < 1) {
                 $('.selectPlateformError').text('Please Select Plateform');
                 return false;
             } else {
                 $('.selectPlateformError').text('');
             }

             if ($('#selectServicesCategory').val() < 1) {
                 $('.selectServicesCategoryError').text('Please Select Service Category');
                 return false;
             } else {
                 $('.selectServicesCategoryError').text('');
             }

             if ($('#selectService').val() < 1) {
                 $('.selectServiceError').text('Please Select Service');
                 return false;
             } else {
                 $('.selectServiceError').text('');
             }

             if ($('.serviceLink').val() == '') {
                 $('.errorLink').show();
                 $('.errorLink').text('Please Enter Valid Link.');
                 return false;
             } else {
                 var validateLink = /^(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})/;
                 if (validateLink.test($('.serviceLink').val())) {
                     $('.errorLink').text('');
                 } else {
                     $('.errorLink').show();
                     $('.errorLink').text('Please Enter Valid Link.');
                     return false;
                 }
                 $('.errorLink').hide();
             }

             if ($('#quantity').val() == '') {
                 $('.errorQty').show();
                 $('.errorQty').text('Please Enter Quantity.');
                 return false;
             } else {
                 $('.errorQty').hide();
             }

             var plateform = $('#plateform').val();
             var selectServicesCategory = $('#selectServicesCategory').val();
             var selectService = $('#selectService').val();
             var serviceLink = $('#serviceLink').val();
             var quantity = $('#quantity').val();
             var data = {};

             data.action = 'submitOrder';
             data.plateform_id = plateform;
             data.selectServicesCategory_id = selectServicesCategory;
             data.selectService_id = selectService;
             data.serviceLink = serviceLink;
             data.quantity = quantity;
             data.usageCharge = $('.chargeAmount').text();
             data.usageChargeINR = $('#totalChargeINR').val();

             $.ajax({
                 url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                 type: "post",
                 data: data,
                 success: function(response) {},
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
             });

         });
     });
 </script>