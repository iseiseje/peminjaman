<script>
  $(function () {
    $('#createCommodityModal').on('shown.bs.modal', () => {
      $('#createCommodityModal').find('input').not('[type=hidden]')[0].focus();
    });

    $('#editCommodityModal').on('shown.bs.modal', () => {
      $('#editCommodityModal').find('input').not('[type=hidden]')[0].focus();
    });

    $('.datatable').on('click', '.editCommodityButton', function (e) {
      let id = $(this).data('id');
      let showURL = "{{ route('api.v1.commodities.show', 'param') }}";
      let updateURL = "{{ route('administrators.commodities.update', 'param') }}";
      showURL = showURL.replace('param', id);
      updateURL = updateURL.replace('param', id);

      let input = $('#editCommodityModal :input').not('[type=hidden]').not('.btn-close').not('.close-button').not('[type=submit]');
      input.val('Sedang mengambil data..');
      input.attr('disabled', true);

      $.ajax({
        url: showURL,
        method: 'GET',
        success: (res) => {
          input.attr('disabled', false);
          $('#editCommodityModal #name').val(res.data.name);
          $('#editCommodityModal #category_id').val(res.data.category_id);
          $('#editCommodityModal #program_study_id').val(res.data.program_study_id);
          $('#editCommodityModal #item_code').val(res.data.item_code);
          $('#editCommodityModal #stock').val(res.data.stock);
          $('#editCommodityModal #condition').val(res.data.condition);
          $('#editCommodityModal form').attr('action', updateURL);
        },
        error: (err) => {
          Swal.fire(
            'Error',
            'Terjadi kesalahan, lapor kepada administrator!',
            'error'
          );

          $('#editCommodityModal').on('shown.bs.modal', () => {
            $('#editCommodityModal').modal('hide');
          });
        }
      });
    });
  });
</script>
