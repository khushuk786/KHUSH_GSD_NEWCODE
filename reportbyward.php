<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Report By Ward</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Report by Ward</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <div class="dataTable-search">
                                <select required class="form-control" name="ward" id="ward">
                                    <option value="">Select Ward Type</option>
                                    <?=load_ward()?>
                                </select>
                            </div>
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

    </section>
</main>

<?php include(root.'common/footer.php'); ?>

<script>
$(document).ready(function() {
    function load_pag() {
        var search = $("[name='ser']").val();
        var ward = $("[name='ward']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'report_action.php' ?>",
            data: {
                action: 'show',
                search: search,
                ward: ward
            },
            success: function(data) {
                $("#show_table").html(data);
            }
        });
    }

    load_pag();

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("change", "#ward", function() {
        var ward_data = $(this).val();
        $("[name='ward']").val(ward_data);
        load_pag();
    });
});
</script>