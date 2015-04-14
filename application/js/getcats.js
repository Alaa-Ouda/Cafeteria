$.ajax({
          url: "scripts/getcats.php",
          cache:false,
          success: function (r) {
                    $("#cat").html(r);
           			
            },
         error: function (e) {
                     alert("error");
            }
        });