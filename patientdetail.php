<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Patient Detail</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="patient.php">Patient</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                <div id="show_detail">
                </div>
            </div>

            </div>
        </div>


        <div class="modal fade text-left" id="btnchangewardmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Change Ward</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmchangeward" method="POST">
                        <input type="hidden" name="action" value="changeward" />
                        <input type="hidden" name="eaid" value="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Ward</label>
                                <input type="hidden" name="wardold" value="">
                                <input type="hidden" name="wavailability" value="">
                                <select required class="form-control" name="ward" id="ward">
                                    <option value="">Select Ward</option>
                                    <?=load_ward()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Bed</label>
                                <input type="hidden" name="bedold" value="">
                                <select required class="form-control" name="bed" id="bed">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn grey btn-outline-danger" data-bs-dismiss="modal"><i
                                    class="la la-close"></i>Close</button>
                            <button type="submit" class="btn btn-outline-primary"><i class="la la-edit"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</main>

<?php include(root.'common/footer.php'); ?>

<script>
$(document).ready(function() {
    function load_pag() {
        var search = $("[name='ser']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: {
                action: 'showdetail',
            },
            success: function(data) {
                $("#show_detail").html(data);
            }
        });
    }

    $(document).on("click", "#btnchangeward", function() {
        $("#btnchangewardmodal").modal("show");
    });

    $(document).on("change", "#ward", function() {
        var ward_id = $(this).val();
        load_bed_ward(ward_id); 
    });

    function load_bed_ward(ward_id) {
        if (ward_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo roothtml.'patient_action.php' ?>",
                data: { 
                    action: 'showbed',
                    ward_id: ward_id 
                },
                success: function(data) {
                    // Populate the bed dropdown
                    $("#bed").html(data);
                }
            });
        }
        else {
            $("#bed").html("<option value=''>Select Bed Number</option>");
        }
    }

    $("#frmchangeward").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btnchangewardmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    $("[name='name']").val("");
                    $("[name='age']").val("");
                    $("[name='gender']").val("");
                    swal("Success", "Save data is successful.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", data, "error");
                }
            }
        });
    });

    load_pag();
});
</script>