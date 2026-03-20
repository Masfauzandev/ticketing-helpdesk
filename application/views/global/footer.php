</div>
</div>
</div>
<style>
    /* Ensure Select2 dropdowns fill their parent container */
    .select2-container { width: 100% !important; }
</style>
<!-- Page Footer-->
<footer class="main-footer" style="background-color: #dc3545; padding: 15px 0;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <p style="color: #ffffff; font-weight: 500; margin: 0; font-size: 16px;"><?= DEV_COMPANY_NAME ?> &copy; 2026</p>
            </div>
        </div>
    </div>
</footer>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= BASE_URL ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="<?= BASE_URL ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script><!-- Main File-->
<script src="<?= BASE_URL ?>assets/js/front.js"></script>
<script src="<?= BASE_URL ?>assets/js/library.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>assets/js/tik-script.js"></script>
<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            // Animate loader off screen
            $(".loader").fadeOut(1000);
        })

        // Initialize Select2 on all select elements inside .select containers
        // (skip IDs already initialised by library.js: category_dd, severity_dd, cc_dd, etc.)
        if ($.fn.select2) {
            $('.select select').not('#subject_dd, #category_dd, #severity_dd, #cc_dd, #status_dd, #assign_to_dd, #priority_dd').select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            $('.select select[multiple]').not('#subject_dd, #category_dd, #cc_dd').select2({
                width: '100%',
                minimumResultsForSearch: -1
            });
            $('.form-control-select2').select2({ width: '100%' });
        }
    });

    function addBrAfterXWords(e, data) {
        let words = e;
        let text = data.split(" ");
        let newhtml = [];
        console.log("TEST text:" + text);

        for (var i = 0; i < text.length; i++) {

            if (i > 0 && (i % words) == 0)
                newhtml.push("<br />");

            newhtml.push(text[i]);
        }
        return newhtml.join(" ");
    }

    /*to get user icon*/
    $('.current-user-avatar').each(function (elem) {
        console.log($(this).attr('data-username'));
        var username = $(this).attr('data-username');
        var name = username.split('.').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
        console.log(name);
        $(this).append(getUserLabel(name, username))
    });
</script>
</body>

</html>