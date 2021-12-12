<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:30 pm */ ?>
<script>
    $(".favority").click(function (){
        let type = 'delete';
        let offerId = $(this).attr('data-offer-id');
       if ($(this).hasClass('active')){
           type = 'delete';
       }
       else {
           type = 'add'
       }
        $.ajax({
            type: "POST",
            data: {
                'type' : type,
                'offer_id' : offerId
            },
            url: '/_ajax?core[ajax]=true&core[call]=homdom.userFavority',
            success: function (response) {
                console.log(response)
            }
        });

       console.log(type)
       console.log(offerId)
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>
