<button id="open-picker">Open resource picker</button>
  <script>
    document
      .getElementById('open-picker')
      .addEventListener('click', async () => {
        const selected = await shopify.resourcePicker({type: 'product'});
        // shopify.toast.show('Message sent');
        console.log(selected);
      });
  </script>
<script>
    
   

//   //============================================
//   //        GETTING SESSION TOKEN
//   //============================================

//   const getSessionToken = AppBridgeUtil.getSessionToken;

//   getSessionToken(app).then(token => {
//     var formData = new FormData();
//     formData.append('token', token);

//     fetch('verify_session.php', {
//       method: 'POST',
//       header: {
//         'Content-Type': 'application/json'
//       },
//       body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//       console.log(data);

//       if(data.success) {
//         axios({
//           method: 'POST',
//           url: 'authenticatedFetch.php',
//           data: {
//             shop: data.shop.host,
//             query: `query {
//                       products(first: 2) {
//                         edges {
//                           node {
//                             id
//                             title
//                             description
//                             images(first: 1) {
//                               edges {
//                                 node {
//                                   originalSrc
//                                 }
//                               }
//                             }
//                             status
//                           }
//                         }
//                       }
//                     }
// `
//           },
//           headers: {
//             'Content-Type': 'application/json',
//             'Authorization': 'Bearer: ' + token
//           }
//         }).then((response) => {
//           //console.log(response.data);
//         })
//       }
//     });
//   });
</script>
</body>
</html>