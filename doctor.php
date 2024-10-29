<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Doctor</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" id="btnnew"><i class="bi bi-star me-1"></i> New Doctor</button>
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
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Add New Doctor</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmsave" method="POST">
                        <input type="hidden" name="action" value="save" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Doctor Name</label>
                                <input type="text" required class="form-control" name="name" placeholder="Doctor Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Doctor Team</label>
                                <select required class="form-control" name="team" id="team">
                                    <option value="">Select Doctor Team</option>
                                    <?=load_team()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Grade</label>
                                <select required class="form-control" name="grade" id="grade">

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

        <!-- edit Modal -->
        <div class="modal fade text-left" id="btneditmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Edit Doctor Information</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmedit" method="POST">
                        <input type="hidden" name="action" value="edit" />
                        <input type="hidden" name="eaid" value="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Doctor Name</label>
                                <input type="text" required class="form-control" name="ename" placeholder="Doctor Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Doctor Team</label>
                                <select required class="form-control" name="eteam">
                                    <option value="">Select Doctor Team</option>
                                    <?=load_team()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Grade</label>
                                <select required class="form-control" name="egrade">
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
            url: "<?php echo roothtml.'doctor_action.php' ?>",
            data: {
                action: 'show',
                search: search
            },
            success: function(data) {
                $("#show_table").html(data);
            }
        });
    }

    function load_grade(team_id) {
        if (team_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo roothtml.'doctor_action.php' ?>",
                data: { 
                    action: 'showgrade',
                    team_id: team_id 
                },
                success: function(data) {
                    $("#grade").html(data);
                }
            });
        }
        else {
            $("#bed").html("<option value=''>Select Bed Number</option>");
        }
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

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("change", "#team", function() {
        var team = $(this).val();
        load_grade(team); 
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
            url: "<?php echo roothtml.'doctor_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    $("[name='name']").val("");
                    $("[name='grade']").val("");
                    $("[name='team']").val("");
                    swal("Success", "Save data is successful.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", "Save data is error", "error");
                }
            }
        });
    });

    $(document).on("click", "#btndetail", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'doctor_action.php' ?>",
            data: {
                action: 'go_detail',
                aid: aid
            },
            success: function(data) {
                if (data == 1) {
                    location.href = "<?=roothtml.'doctordetail.php'?>";
                }       
            }
        });
    });

    $(document).on("click", "#btnedit", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var name = $(this).data("name");
        var grade = $(this).data("grade");
        var team = $(this).data("team");
        $("[name='eaid']").val(aid);
        $("[name='ename']").val(name);
        $("[name='egrade']").val(grade);
        $("[name='eteam']").val(team);
        $("#btneditmodal").modal("show");
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btneditmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'doctor_action.php' ?>",
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
        var name = $(this).data("name");
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
                    url: "<?php echo roothtml.'doctor_action.php'; ?>",
                    data: {
                        action: 'delete',
                        aid: aid,
                        name: name
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