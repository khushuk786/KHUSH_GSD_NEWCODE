<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Patient</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" id="btnnew"><i class="bi bi-star me-1"></i> New Patient</button>
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
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Add New Patient</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmsave" method="POST">
                        <input type="hidden" name="action" value="save" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Patient Name</label>
                                <input type="text" required class="form-control" name="name" placeholder="Patient Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Age</label>
                                <input type="text" required class="form-control" name="age" placeholder="Age">
                            </div>
                            <div class="form-group">
                                <label for="usr">Gender</label>
                                <select required class="form-control" name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <?=load_gender()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Ward</label>
                                <select required class="form-control" name="ward" id="ward">
                                    <option value="">Select Ward</option>
                                    <?=load_ward()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Bed</label>
                                <select required class="form-control" name="bed" id="bed">
                                    
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Team</label>
                                <select required class="form-control" name="team">
                                    <option value="">Select Doctor Team</option>
                                    <?=load_team()?>
                                </select>
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
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Edit Patient Information</label>
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
                                <input type="text" required class="form-control" name="ename" placeholder="Patient Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Age</label>
                                <input type="text" required class="form-control" name="eage" placeholder="Age">
                            </div>
                            <div class="form-group">
                                <label for="usr">Gender</label>
                                <select required class="form-control" name="egender" id="egender">
                                    <option value="">Select Gender</option>
                                    <?=load_gender()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Ward</label>
                                <input type="hidden" name="ewavailability" value="">
                                <select required class="form-control" name="eward" id="eward">
                                    <option value="">Select Ward</option>
                                    <?=load_ward()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Bed</label>
                                <input type="hidden" name="ebedold" value="">
                                <select required class="form-control" name="ebed" id="ebed">
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Team</label>
                                <select required class="form-control" name="eteam">
                                    <option value="">Select Doctor Team</option>
                                    <?=load_team()?>
                                </select>
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
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: {
                action: 'show',
                search: search
            },
            success: function(data) {
                $("#show_table").html(data);
            }
        });
    }

    load_pag();

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

    function load_ebed_ward(ward_id, bed_id, bed_number) {
        
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: { 
                action: 'showebed',
                ward_id: ward_id,
                bed_id: bed_id,
                bed_number: bed_number
            },
            success: function(data) {
                // Populate the bed dropdown
                $("#ebed").html(data);
            }
        });
        
    }

    $(document).on("change", "#ward", function() {
        var ward_id = $(this).val();
        load_bed_ward(ward_id); 
    });

    $(document).on("change", "#eward", function() {
        var ward_id = $(this).val();
        load_ebed_ward(ward_id); 
    });

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("click", "#btnnew", function() {
        load_bed_ward(""); 
        $("#btnnewmodal").modal("show");
    });

    $("#frmsave").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btnnewmodal").modal("hide");
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


    $(document).on("click", "#btndetail", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var ward = $(this).data("ward");
        var bed = $(this).data("bed");
        var available = $(this).data("wavailability");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: {
                action: 'go_detail',
                aid: aid,
                ward: ward,
                bed: bed,
                available: available
            },
            success: function(data) {
                if (data == 1) {
                    location.href = "<?=roothtml.'patientdetail.php'?>";
                }    
            }
        });
    });

    $(document).on("click", "#btnedit", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var name = $(this).data("name");
        var age = $(this).data("age");
        var gender = $(this).data("gender");
        var ward = $(this).data("ward");
        var wavailability = $(this).data("wavailability");
        var bed = $(this).data("bed");
        var bednumber = $(this).data("bednumber");
        var team = $(this).data("team");
        var dt = $(this).data("dt"); 
        load_ebed_ward(ward, bed, bednumber);
        $("[name='eaid']").val(aid);
        $("[name='ename']").val(name);
        $("[name='eage']").val(age);
        $("[name='egender']").val(gender);
        $("[name='eward']").val(ward);
        $("[name='ewavailability']").val(wavailability);
        $("[name='ebed']").val(bed);
        $("[name='ebedold']").val(bed);
        $("[name='eteam']").val(team);
        $("[name='edt']").val(dt);
        $("#btneditmodal").modal("show");
        load_ebed_ward(ward, bed, bednumber);
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btneditmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'patient_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    swal("Success", "Edit data is successful.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", "Edit data is error", "error");
                }
            }
        });
    });

    $(document).on("click", "#btndelete", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var ward = $(this).data("ward");
        var bed = $(this).data("bed");
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
                    url: "<?php echo roothtml.'patient_action.php'; ?>",
                    data: {
                        action: 'delete',
                        aid: aid,
                        ward: ward,
                        bed: bed
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Delete data success.",
                                "success");
                            load_pag();
                            swal.close();
                        } else {
                            swal("Error",
                                "Delete data failed.",
                                "error");
                        }
                    }
                });
            });
    });



});
</script>