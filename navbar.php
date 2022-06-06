
<style>
</style>
<nav id="sidebar" class='' style="background: blue;" >
		
		<div class="sidebar-list" style="background: blue;">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=appointments" class="nav-item nav-appointments"><span class='icon-field'><i class="fa fa-calendar"></i></span> Outpatients</a>
				<a href="index.php?page=doctors" class="nav-item nav-doctors"><span class='icon-field'><i class="fa fa-user-md"></i></span> Doctors</a>
            <a href="index.php?page=report" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-book-open"></i></span> Reports</a>
<!--				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-book-medical"></i></span> Medical Specialties</a>			-->
				<?php if($_SESSION['login_type'] == 1): ?>
            <style>
                .nav-sales ,.nav-users,.nav-doctors,.nav-reports{
                    display: none!important;
                }
            </style>


				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
<!--				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cog"></i></span> Site Settings</a>-->
			<?php endif; ?>
		</div>

</nav>


<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<?php if($_SESSION['login_type'] == 2): ?>
	<style>
		.nav-sales ,.nav-users,.nav-docto,.nav-categories{
			display: none!important;
		}
	</style>


<?php elseif  ($_SESSION['login_type'] == 4): ?>
        <style>
            .nav-sales ,.nav-users,.nav-doctors,.nav-categories{
                display: none!important;
            }
        </style>
<?php endif ?>