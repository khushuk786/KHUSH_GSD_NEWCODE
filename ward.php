<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Ward</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" id="btnnew"><i class="bi bi-star me-1"></i> New Ward</button>
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
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Add New Ward</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmsave" method="POST">
                        <input type="hidden" name="action" value="save" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Ward Name</label>
                                <input type="text" required class="form-control" name="name" placeholder="Enter Ward Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Ward Type</label>
                                <select required class="form-control" name="type">
                                    <option value="">Select Ward Type</option>
                                    <?=load_gender()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Capacity</label>
                                <input type="number" required class="form-control" name="capacity" placeholder="Enter Ward capacity">
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
                        <label class="modal-title text-text-bold-600" id="myModalLabel25">Edit Ward Information</label>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmedit" method="POST">
                        <input type="hidden" name="action" value="edit" />
                        <input type="hidden" name="eaid" value="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Ward Name</label>
                                <input type="text" required class="form-control" name="ename" placeholder="Enter Ward Name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Ward Type</label>
                                <select required class="form-control" name="etype">
                                    <option value="">Select Ward Type</option>
                                    <?=load_gender()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr">Capacity</label>
                                <input type="number" required class="form-control" name="ecapacity" placeholder="Enter Ward capacity">
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
            url: "<?php echo roothtml.'ward_action.php' ?>",
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

    $(document).on("click", "#btnnew", function() {
        $("#btnnewmodal").modal("show");
    });

    $("#frmsave").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btnnewmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'ward_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    $("[name='name']").val("");
                    $("[name='type']").val("");
                    $("[name='capacity']").val("");
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
        var name = $(this).data("name");
        var type = $(this).data("type");
        var capacity = $(this).data("capacity");
        $("[name='eaid']").val(aid);
        $("[name='ename']").val(name);
        $("[name='etype']").val(type);
        $("[name='ecapacity']").val(capacity);
        $("#btneditmodal").modal("show");
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btneditmodal").modal("hide");
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'ward_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    swal("Success", "Edit data is successful.", "success");
                    load_pag();
                    swal.close();
                } else {
                    swal("Error", data, "error");
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
                    url: "<?php echo roothtml.'ward_action.php'; ?>",
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