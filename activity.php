<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Activity Log History</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">

            <div class="card">
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

    </section>
</main>

<?php include(root.'common/footer.php'); ?>

<script>
$(document).ready(function() {
    function load_pag() {
        var search = $("[name='ser']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'activity_action.php' ?>",
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

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });
});
</script>