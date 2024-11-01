<?php 
    include('config.php');
    include(root.'common/header.php');
?>

<!-- BEGIN: Content-->
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Report By Patient</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-top">
                                <div class="dataTable-search">
                                    <select required class="form-control" name="patient" id="patient">
                                        <option value="">Select Patient</option>
                                        <?=load_patient()?>
                                    </select>
                                </div>
                                <div class="dataTable-search">
                                    <input type="hidden" name="ser">
                                    <input class="dataTable-input" placeholder="Search..." type="search" id="searching">
                                </div>
                            </div>
                            <div id="show_detail" class="dataTable-container">

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
        var patient = $("[name='patient']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'report_action.php' ?>",
            data: {
                action: 'showbypatient',
                search: search,
                patient: patient
            },
            success: function(data) {
                $("#show_detail").html(data);
            }
        });
    }

    load_pag();

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("change", "#patient", function() {
        var patient_data = $(this).val();
        $("[name='patient']").val(patient_data);
        load_pag();
    });
});
</script>