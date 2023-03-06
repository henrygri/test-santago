$(document).ready(function () {

    /*
    let items = [
      'Contatti/Lead',
      'Aziende',
      'Commesse',
      'Incarichi',
      'Offerte',
      'Consulenti/Docenti',
      'Piani/Bandi'
    ];

    let select = document.createElement("select");
    select.classList.add('form-control');
    select.name = 'search_general';

    items.forEach(item => {
      let option = document.createElement("option");
      option.value = item;
      option.text = item;
      select.add(option);
    });
    
    $('.navbar-search-block .btn-navbar[type="submit"]').after(select)
    */
    $('#datatables,#datatables2,#datatables3').DataTable({
      info: true,
      order: [0,'desc'],
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Italian.json'
      },
      pageLength: 25,
      columnDefs: [
        {
          orderable: false,
          targets: "no-sort"
        }
      ],
    });

    $('.confirm_delete').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: `Elimina record`,
            text: "Attenzione! questa è un’operazione irreversibile. Sei sicuro di voler eliminare il record?",
            showCancelButton: true,
            showCloseButton: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
    });

    $(".number_format").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));    
    })

    /*
    easyNumberSeparator({
      selector: '.number_format',
      separator: ',',
    });
    */

    $.each($('select'), function(index, element) {
      let attr = $(element).attr('multiple');
      let obj = {}
      obj.placeholder = "Seleziona una voce"
      if (typeof attr !== typeof undefined && attr !== false) {
        obj.placeholder = "Seleziona una o più voci"
      }
      if($(element).hasClass('modalSelect2')) {
        //let $modal = $(element).closest('.modal')
        //obj.dropdownParent = $modal
        let $parent = $(element).parent()
        obj.dropdownParent = $parent
      }

      $(element).select2(obj)
    })
   
});