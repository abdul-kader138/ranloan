<?php
$settingResult = $this->db->get_where('site_setting');
$settingData = $settingResult->row();
$setting_site_name = @$settingData->site_name;
	
$format_array = ci_date_format();
$site_dateformat = $format_array['siteSetting_dateformat'];
$site_currency = $format_array['siteSetting_currency'];
$dateformat = $format_array['dateformat'];
?>
<div class="login_footer">
	<div class="copy">&copy; <?php echo date('Y', time()); ?> - <?php echo $setting_site_name; ?> - All Rights Reserved.</div>
</div>

<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url()?>assets/js/multiple-select.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-select.js"></script>
    <script>
        $( function() {
			 
            $( "#startDate" ).datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
            });

            $("#endDate").datepicker({
                format: 'yyyy-mm-dd',
				autoclose: true,
            });
        } );
    </script>
	<script>
/*$('.parent').click(function(){ 
$('.parent').removeClass('active'); 
$(this).addClass('active'); 
});*/

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})



	</script>

<script type="text/javascript">
	                function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>
</body>
</html>