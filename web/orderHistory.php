 <div class="pageWrapper">
     <div class="">
         <div class="Polaris-Box" style="--pc-box-padding-block-end-xs:var(--p-space-4);--pc-box-padding-block-end-md:var(--p-space-5);--pc-box-padding-block-start-xs:var(--p-space-4);--pc-box-padding-block-start-md:var(--p-space-5);--pc-box-padding-inline-start-xs:var(--p-space-4);--pc-box-padding-inline-start-sm:var(--p-space-0);--pc-box-padding-inline-end-xs:var(--p-space-4);--pc-box-padding-inline-end-sm:var(--p-space-0);position:relative">
             <div class="Polaris-Page-Header--isSingleRow Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
                 <div class="Polaris-Page-Header__Row">
                     <div class="Polaris-Page-Header__TitleWrapper">
                         <h1 class="Polaris-Header-Title" style="text-align: left;">Order History</h1>
                     </div>
                 </div>
             </div>
         </div>
         <div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented orderhistoryTabGroup" data-buttongroup-segmented="true">
             <div class="Polaris-ButtonGroup__Item">
                 <button class="Polaris-Button Polaris-Button--pressed allTab  " data-tabId="0" type="button" aria-pressed="true">
                     <span class="Polaris-Button__Content">
                         <span class="Polaris-Button__Text">All</span>
                     </span>
                 </button>
             </div>
             <div class="Polaris-ButtonGroup__Item">
                 <button class="Polaris-Button pendingTab" data-tabId="1" type="button" aria-pressed="false">
                     <span class="Polaris-Button__Content">
                         <span class="Polaris-Button__Text">Pending</span>
                     </span>
                 </button>
             </div>
             <div class="Polaris-ButtonGroup__Item">
                 <button class="Polaris-Button processingTab " data-tabId="2" type="button" aria-pressed="false">
                     <span class="Polaris-Button__Content">
                         <span class="Polaris-Button__Text">processing</span>
                     </span>
                 </button>
             </div>
             <div class="Polaris-ButtonGroup__Item">
                 <button class="Polaris-Button completedTab " data-tabId="3" type="button" aria-pressed="false">
                     <span class="Polaris-Button__Content">
                         <span class="Polaris-Button__Text">Completed</span>
                     </span>
                 </button>
             </div>
             <div class="Polaris-ButtonGroup__Item">
                 <button class="Polaris-Button cancelledTab" data-tabId="4" type="button" aria-pressed="false">
                     <span class="Polaris-Button__Content">
                         <span class="Polaris-Button__Text">Cancelled</span>
                     </span>
                 </button>
             </div>
         </div>
         <div class="">
             <div class="Polaris-LegacyCard">
                 <div class="">
                     <div class="Polaris-DataTable__Navigation">
                         <button class="Polaris-Button Polaris-Button--disabled Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Scroll table left one column" aria-disabled="true" type="button" tabindex="-1">
                             <span class="Polaris-Button__Content">
                                 <span class="Polaris-Button__Icon">
                                     <span class="Polaris-Icon">
                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                         </span>
                                         <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                             <path fill-rule="evenodd" d="M11.78 5.47a.75.75 0 0 1 0 1.06l-3.47 3.47 3.47 3.47a.75.75 0 1 1-1.06 1.06l-4-4a.75.75 0 0 1 0-1.06l4-4a.75.75 0 0 1 1.06 0Z">
                                             </path>
                                         </svg>
                                     </span>
                                 </span>
                             </span>
                         </button>
                         <button class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Scroll table right one column" type="button">
                             <span class="Polaris-Button__Content">
                                 <span class="Polaris-Button__Icon">
                                     <span class="Polaris-Icon">
                                         <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                                         </span>
                                         <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                             <path fill-rule="evenodd" d="M7.72 14.53a.75.75 0 0 1 0-1.06l3.47-3.47-3.47-3.47a.75.75 0 0 1 1.06-1.06l4 4a.75.75 0 0 1 0 1.06l-4 4a.75.75 0 0 1-1.06 0Z">
                                             </path>
                                         </svg>
                                     </span>
                                 </span>
                             </span>
                         </button>
                     </div>
                     <div class="Polaris-DataTable Polaris-DataTable__ShowTotals">
                         <div class="Polaris-DataTable__ScrollContainer">
                             <table class="Polaris-DataTable__Table orderHistoryTable">
                                 <thead>
                                     <tr>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col">Service</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Date</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Link</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Quantity</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Status</th>
                                     </tr>

                                 </thead>
                                 <tbody>
                                     <tr>

                                     </tr>

                                     <!-- <tr class="Polaris-DataTable__TableRow Polaris-DataTable--hoverable">
                                         <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">
                                             <a class="Polaris-Link Polaris-Link--removeUnderline" href="https://www.example.com" data-polaris-unstyled="true">Emerald Silk Gown</a>
                                         </th>
                                         <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$875.00</td>
                                         <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124689</td>
                                         <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">140</td>
                                         <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$122,500.00</td>
                                     </tr> -->
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script type="text/javascript">
     $(document).ready(function() {

         getOrders('0');

         function getOrders(filter) {
             var data = {};
             data.action = 'getOrders';
             data.filter = filter;

             $.ajax({
                 url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                 type: "post",
                 data: data,
                 success: function(response) {
                     var tableRow;
                     var serviceName;
                     var order_status;
                     $.each(JSON.parse(response), function(index, item) {

                         serviceName = item[3].substr(0, 40);

                         order_status = item["order_status"];
                         if (order_status == '1') {
                             order_status = 'Pending';
                         } else if (order_status == '2') {
                             order_status = 'Processing';
                         } else if (order_status == '3') {
                             order_status = 'Completed';
                         } else if (order_status == '4') {
                             order_status = 'Cancelled';
                         } else {

                         }

                         tableRow += '<tr class="Polaris-DataTable__TableRow Polaris-DataTable--hoverable"><th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">' + serviceName + '</th><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric 00">' + item["created"] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + item["link"] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + item["quantity"] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + order_status + '</td></tr>';

                     });

                     $('.orderHistoryTable tbody').html('');
                     $('.orderHistoryTable tbody').html(tableRow);
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
             });
         }

         $('.orderhistoryTabGroup button').on('click', function() {
             var tabId = $(this).attr('data-tabId');
             $('.orderhistoryTabGroup button').removeClass('Polaris-Button--pressed');
             $(this).addClass('Polaris-Button--pressed');
             $('.orderHistoryTable tbody').html('<td colspan="4" style="text-align:center"><span class="Polaris-Spinner Polaris-Spinner--sizeLarge"><svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"><path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path></svg></span><span role="status"><span class="Polaris-Text--root Polaris-Text--visuallyHidden">Spinner example</span></span></td>');
             getOrders(tabId);
         });


     });
 </script>