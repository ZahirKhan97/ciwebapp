        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>
    <!-- Text Editor -->
    <script src="<?php echo base_url()?>public/admin/plugins/summernote/summernote-bs4.js"></script>
    <script>
        $(function() {
            // summernote
            $('.textarea').summernote({
                height : '400px'
            })
            
        })
    </script>

</body>

</html>