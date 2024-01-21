 <div class=" ">
     <div class="">
         <div class="Polaris-Box" style="--pc-box-padding-block-end-xs:var(--p-space-4);--pc-box-padding-block-end-md:var(--p-space-5);--pc-box-padding-block-start-xs:var(--p-space-4);--pc-box-padding-block-start-md:var(--p-space-5);--pc-box-padding-inline-start-xs:var(--p-space-4);--pc-box-padding-inline-start-sm:var(--p-space-0);--pc-box-padding-inline-end-xs:var(--p-space-4);--pc-box-padding-inline-end-sm:var(--p-space-0);position:relative">
             <div class="Polaris-Page-Header--isSingleRow Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
                 <div class="Polaris-Page-Header__Row">
                     <div class="Polaris-Page-Header__TitleWrapper">
                         <h1 class="Polaris-Header-Title" style="text-align: left;">Service List</h1>
                     </div>
                 </div>
             </div>
         </div>
         <div class="">
             <div class="Polaris-LegacyCard">
                 <div class="">
                     <div class="Polaris-DataTable Polaris-DataTable__ShowTotals">
                         <div class="Polaris-DataTable__ScrollContainer">
                             <table class="Polaris-DataTable__Table serviceListTable">
                                 <thead>
                                     <tr>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col">Service</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Min</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Max</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Rate</th>
                                         <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Description</th>
                                     </tr>

                                 </thead>
                                 <tbody>
                                     <tr>
                                     </tr>
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

         getServiceList();

         function getServiceList() {
             var data = {};
             data.action = 'getServiceList';
             data['data'] = '-1';

             $.ajax({
                 url: "index.php?shop=<?php echo $_GET['shop']; ?>",
                 type: "post",
                 data: data,
                 success: function(response) {
                     var tableRow;
                     var serviceName;
                     var order_status;
                     console.log(JSON.parse(response));

                     $.each(JSON.parse(response), function(index, item) {

                         tableRow += '<tr class="Polaris-DataTable__TableRow Polaris-DataTable--hoverable"><th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">' + item['name'] + '</th><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric 00">' + item['min'] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + item["max"] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + item["rate"] + '</td><td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">' + item['description'] + '</td></tr>';

                     });

                     $('.serviceListTable tbody').html('');
                     $('.serviceListTable tbody').html(tableRow);
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
             });
         }
     });
 </script>