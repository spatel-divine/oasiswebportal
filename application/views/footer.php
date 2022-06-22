
					<!--footer-->
					<footer class="footer">
						<div class="container">
							<div class="row align-items-center flex-row-reverse">
								<div class="col-lg-12 col-sm-12   text-center">
									Copyright © 2021 <a href="#">Oasis Movement</a>. Designed by <a href="https://divineinfosys.com/">Divine Infosys</a> All rights reserved.
								</div>
							</div>
						</div>
					</footer>
					<!-- End Footer-->

				</div>
				<!-- End app-content-->
			</div>
		</div>
		<!-- End Page -->

		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
		<!--<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>-->

		<!--Bootstrap.min js-->
		<script src="<?=base_url();?>assets/plugins/bootstrap/popper.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

		<!--Jquery Sparkline js-->
		<script src="<?=base_url();?>assets/js/vendors/jquery.sparkline.min.js"></script>

		<!-- Chart Circle js-->
		<script src="<?=base_url();?>assets/js/vendors/circle-progress.min.js"></script>

		<!-- Star Rating js-->
		<script src="<?=base_url();?>assets/plugins/rating/jquery.rating-stars.js"></script>

		<!--Moment js-->
		<script src="<?=base_url();?>assets/plugins/moment/moment.min.js"></script>

		<!-- Datepicker js -->
		<script src="<?=base_url();?>assets/plugins/spectrum-date-picker/spectrum.js"></script>
		<script src="<?=base_url();?>assets/plugins/spectrum-date-picker/jquery-ui.js"></script>
		<script src="<?=base_url();?>assets/plugins/input-mask/jquery.maskedinput.js"></script>

		<!-- Daterangepicker js-->
		<script src="<?=base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- Horizontal-menu js -->
		<script src="<?=base_url();?>assets/plugins/horizontal-menu/horizontalmenu.js"></script>

		<!--News Ticker js-->
		<script src="<?=base_url();?>assets/plugins/newsticker/breaking-news-ticker.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/newsticker/newsticker.js"></script>

		<!--Time Counter js-->
		<script src="<?=base_url();?>assets/plugins/counters/jquery.missofis-countdown.js"></script>
		<script src="<?=base_url();?>assets/plugins/counters/counter.js"></script>

		<!-- Sidebar Accordions js -->
		<script src="<?=base_url();?>assets/plugins/sidemenu-responsive-tabs/js/easyResponsiveTabs.js"></script>

		<!-- Perfect scroll bar js-->
		<script src="<?=base_url();?>assets/plugins/pscrollbar/perfect-scrollbar.js"></script>

		<!-- Rightsidebar js -->
		<script src="<?=base_url();?>assets/plugins/sidebar/sidebar.js"></script>

		<!-- Data tables js-->
		<script src="<?=base_url();?>assets/plugins/datatable/jquery.dataTables.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/datatable/datatable.js"></script>
		<script src="<?=base_url();?>assets/plugins/datatable/datatable-2.js"></script>
		<script src="<?=base_url();?>assets/plugins/datatable/dataTables.responsive.min.js"></script>

		<!-- File uploads js -->
		<script src="<?=base_url();?>assets/plugins/fileuploads/js/dropify.js"></script>
		<script src="<?=base_url();?>assets/plugins/fileuploads/js/dropify-demo.js"></script>

		<!-- WYSIWYG Editor js -->
		<script src="<?=base_url();?>assets/plugins/wysiwyag/jquery.richtext.js"></script>
		<script src="<?=base_url();?>assets/plugins/wysiwyag/richText1.js"></script>

		<!--Summernote js-->
		<script src="<?=base_url();?>assets/plugins/summernote/summernote-bs4.js"></script>
		<script src="<?=base_url();?>assets/js/summernote.js"></script>
		
		<!-- ECharts js -->
		<script src="<?=base_url();?>assets/plugins/echarts/echarts.js"></script>

		<!--Advanced Froms js-->
		<script src="<?=base_url();?>assets/js/advancedform.js"></script>

		<!-- Custom-charts js-->
		<script src="<?=base_url();?>assets/js/index4.js"></script>

		<!--Rating js-->
		<script src="<?=base_url();?>assets/plugins/rating/jquery.barrating.js"></script>
		<script src="<?=base_url();?>assets/plugins/rating/js/examples.js"></script>

		<!-- Custom js-->
		<script src="<?=base_url();?>assets/js/custom.js"></script>
		<script src="<?=base_url();?>assets/js/tooltipster.bundle.js"></script>
		<script src="https://cdn.jsdelivr.net/gh/hummingbird-dev/hummingbird-treeview@v3.0.0/hummingbird-treeview.min.js"></script>


		<script type="text/javascript">
    		$('.select2').select2({
    			placeholder: "--Select--",
    		});
		</script>
		<script type="text/javascript">
    		$('.facilitator_search').select2({
			   // multiple: true,
			    placeholder: "Select Facilitator",
			    allowClear: true
			});
			$('.cofacilitator_search').select2({
			   // multiple: true,
			    placeholder: "Select Co-Facilitator",
			    allowClear: true
			});
			$('.coordinator_search').select2({
			   // multiple: true,
			    placeholder: "Select Co-Ordinator",
			    allowClear: true
			});
			$('.volunteer_search').select2({
			   // multiple: true,
			    placeholder: "Select Volunteer",
			    allowClear: true
			});
			$('.participant_search').select2({
			   // multiple: true,
			    placeholder: "Select Participant",
			    allowClear: true
			});

			$('.quality_observed').select2({
			   // multiple: true,
			    placeholder: "Select Qualities Observed",
			    allowClear: true
			});

			$('.next_level_role').select2({
			   // multiple: true,
			    placeholder: "Select Next Level Role",
			    allowClear: true
			});

			$('.next_level_program').select2({
			   // multiple: true,
			    placeholder: "Select Next Level Program",
			    allowClear: true
			});

			$('.program_list').select2({
			    placeholder: "Select Program",
			    allowClear: true
			});

		</script>
<!--Dynamic Input Creation-->	
<script>
$(document).ready(function (){
	if($.fn.DataTable.isDataTable('#example2')){
     	$('#example2').DataTable().destroy();
     	initResultDataTable();
    }
    /*$('.myTable').DataTable({
    	"paging":   false,
        "ordering": false,
        "info":     false,
        "searching":false,
    });*/
});
function initResultDataTable(){
    $('#example2').DataTable({
        "order": [],
        "scrollX": true,
        "scrollY": true,
        "paging": true,
        "columnDefs": [ {
        "orderable": false,  "targets": [0]
        }]
    });
    $('#example2').DataTable().draw();
}
function updateDataTableRow(rowid,updated_data){
	var table =  $('#example2').DataTable();
	table.row('#'+rowid).data(updated_data).draw();
}
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();  
  $('table').removeClass("text-center"); 
  $('div .table-responsive').addClass("wrapper"); 
  //$('table').attr('id','myTable'); //DON'T UNCOMMENT IT
  //$('table').addClass('myTable');
  $('table').removeClass("text-wrap");
  $(".breadcrumb-item").parents('.card-body').css("background", "rgb(204, 232, 181,50%)");
});
</script>

	</body>
</html>
