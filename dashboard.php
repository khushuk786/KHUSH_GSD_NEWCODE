<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body stats">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="info" id="showdoctor"></h3>
                                <h6>Doctors</h6>
                            </div>
                            <div>
                                <i class="icon-basket-loaded info font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body stats">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success" id="showpatient"></h3>
                                <h6>Patients</h6>
                            </div>
                            <div>
                                <i class="icon-user-follow success font-large-2 float-right"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body stats">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary" id="showmalebed"></h3>
                                <h6>Available beds <br>in Male wards</h6>
                            </div>
                            <div>
                                <i class="la la-dollar primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body stats">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="warning" id="showfemalebed"></h3>
                                <h6>Available beds <br>in Female wards</h6>
                            </div>
                            <div>
                                <i class="icon-pie-chart warning font-large-2 float-right"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ward Availability</h5>
                <div style="margin-bottom: 10px;">
                    <label for="usr"><b>Filter By Ward</b></label>
                    <select required class="form-control" name="ward" id="ward">
                        <option value="">Select Ward Name</option>
                        <?=load_ward()?>
                    </select>
                </div>
                <div id="show_ward" class="dataTable-container">

                </div>
            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Appointment</h5>
                <div id="show_appointment" class="dataTable-container">

                </div>
            </div>
          </div>

        </div>
      </div>
    </section>
</main>

<?php include(root.'common/footer.php'); ?>

<script>
$(document).ready(function() {
    function load_pag() {
        var ward = $("[name='ward']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'show',
                ward: ward
            },
            success: function(data) {
                $("#show_ward").html(data);
            }
        });
    }

    function load_countpatient() {
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'showpatient'
            },
            success: function(data) {
                $("#showpatient").html(data);
            }
        });
    }

    function load_countdoctor() {
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'showdoctor'
            },
            success: function(data) {
                $("#showdoctor").html(data);
            }
        });
    }

    function load_countmalebed() {
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'showmalebed'
            },
            success: function(data) {
                $("#showmalebed").html(data);
            }
        });
    }

    function load_countfemalebed() {
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'showfemalebed'
            },
            success: function(data) {
                $("#showfemalebed").html(data);
            }
        });
    }

    function load_appointment() {
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'dashboard_action.php' ?>",
            data: {
                action: 'show_appointment',
            },
            success: function(data) {
                $("#show_appointment").html(data);
            }
        });
    }

    load_pag();
    load_countpatient();
    load_countdoctor();
    load_countmalebed();
    load_countfemalebed();
    load_appointment();
});
</script>