<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Appointment</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" id="btnnew"><i class="bi bi-star me-1"></i> New Appointment</button>
                </div>
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <div class="dataTable-search">
                                <input type="hidden" name="ser">
                                <input class="dataTable-input" placeholder="Search..." type="search" id="searching">
                            </div>
                        </div>
                        <div id="show_table" class="dataTable-container">

                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>

        <!-- new Modal -->
        <div class="modal fade text-left" id="btnnewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Add New Appointment</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmsave" method="POST">
                        <input type="hidden" name="action" value="save" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Patient Name</label>
                                <select required class="form-control" name="patient" id="patient">
                                    <option value="">Select Patient</option>
                                    <?=load_patient()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Doctor</label>
                                <select required class="form-control" name="doctor" id="doctor">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Notes</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="usr">Date</label>
                                <input type="date" required class="form-control" name="dt">
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

        <!-- edit Modal -->
        <div class="modal fade text-left" id="btneditmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Edit Appointment Information</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmedit" method="POST">
                        <input type="hidden" name="action" value="edit" />
                        <input type="hidden" name="eaid" value="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Patient Name</label>
                                <select required class="form-control" name="epatient" id="epatient">
                                    <option value="">Select Patient</option>
                                    <?=load_patient()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Doctor</label>
                                <select required class="form-control" name="edoctor" id="edoctor">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Notes</label>
                                <textarea name="enotes" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="usr">Date</label>
                                <input type="date" required class="form-control" name="edt">
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
            url: "<?php echo roothtml.'appointment_action.php' ?>",
            data: {
                action: 'show',
                search: search
            },
            success: function(data) {
                $("#show_table").html(data);
            }
        });
    }



    function load_doctor(patient_id) {
        if (patient_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo roothtml.'appointment_action.php' ?>",
                data: { 
                    action: 'showdoctor',
                    patient_id: patient_id 
                },
                success: function(data) {
                    $("#doctor").html(data);
                }
            });
        }
        else {
            $("#doctor").html("<option value=''>Select Doctor</option>");
        }
    }

    function load_edoctor(patient_id, doctor_id) {
        
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'appointment_action.php' ?>",
            data: { 
                action: 'showedoctor',
                patient_id: patient_id,
                doctor_id: doctor_id
            },
            success: function(data) {
                $("#edoctor").html(data);
            }
        });
        
    }

    load_pag();

    $(document).on('click', '.page-link', function() {
        var pageid = $(this).data('page_number');
        load_pag(pageid);
    });

    $(document).on("change", "#entry", function() {
        var entryvalue = $(this).val();
        $("[name='hid']").val(entryvalue);
        load_pag();
    });

    $(document).on("change", "#patient", function() {
        var patient_id = $(this).val();
        load_doctor(patient_id); 
    });

    $(document).on("change", "#epatient", function() {
        var patient_id = $(this).val();
        load_edoctor(patient_id); 
    });

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("click", "#btnnew", function() {
        $("#btnnewmodal").modal("show");
    });

    $("#frmsave").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btnnewmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'appointment_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    $("[name='patient']").val("");
                    $("[name='doctor']").val("");
                    $("[name='notes']").val("");
                    $("[name='dt']").val("");
                    swal("Success", "Save data is successful.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", data, "error");
                }
            }
        });
    });

    $(document).on("click", "#btnedit", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var patient = $(this).data("patient");
        var doctor = $(this).data("doctor");
        var dname = $(this).data("dname");
        var notes = $(this).data("notes");
        var dt = $(this).data("dt");
        load_edoctor(patient, doctor);
        $("[name='eaid']").val(aid);
        $("[name='epatient']").val(patient);
        $("[name='edoctor']").val(doctor);
        $("[name='enotes']").val(notes);
        $("[name='edt']").val(dt);
        $("#btneditmodal").modal("show");
        load_edoctor(patient, doctor);
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btneditmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'appointment_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    swal("Success", "Successfully Edited.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", "Error has been occured", "error");
                }
            }
        });
    });

    $(document).on("click", "#btndelete", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        swal({
                title: "Delete?",
                text: "Are you sure delete!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: "<?php echo roothtml.'appointment_action.php'; ?>",
                    data: {
                        action: 'delete',
                        aid: aid
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Successfully Deleted",
                                "success");
                            load_pag();
                            swal.close();
                        } else {
                            swal("Error",
                                "Error has been occured",
                                "error");
                        }
                    }
                });
            });
    });


});
</script>