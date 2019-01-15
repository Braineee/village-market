<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?= BASE_URL; ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>assets/js/popper.min.js"></script>

<!-- use online -->
<!--script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script-->
<!--script src="../../dist/js/bootstrap.min.js"></script-->

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace()
</script>
<!--modal-->
<script>
  $(document).ready(function() {
     $("#MyModal").modal();
     $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').focus();
     });
  });
</script>
</body>
</html>
