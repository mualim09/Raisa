$('#revEdit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var revmenu = button.data('nama') // Extract info from data-* attributes
    var revjanuari = button.data('januari')
    var revfebruari = button.data('februari')
    var revmaret = button.data('maret')
    var revapril = button.data('april')
    var revmei = button.data('mei')
    var revjuni = button.data('juni')
    var revjuli = button.data('juli')
    var revagustus = button.data('agustus')
    var revseptember = button.data('september')
    var revoktober = button.data('oktober')
    var revnovember = button.data('november')
    var revdesember = button.data('desember')
    var modal = $(this)
    modal.find('.modal-body input[name="nama"]').val(revmenu)
    modal.find('.modal-body input[name="januari"]').val(revjanuari)
    modal.find('.modal-body input[name="februari"]').val(revfebruari)
    modal.find('.modal-body input[name="maret"]').val(revmaret)
    modal.find('.modal-body input[name="april"]').val(revapril)
    modal.find('.modal-body input[name="mei"]').val(revmei)
    modal.find('.modal-body input[name="juni"]').val(revjuni)
    modal.find('.modal-body input[name="juli"]').val(revjuli)
    modal.find('.modal-body input[name="agustus"]').val(revagustus)
    modal.find('.modal-body input[name="september"]').val(revseptember)
    modal.find('.modal-body input[name="oktober"]').val(revoktober)
    modal.find('.modal-body input[name="november"]').val(revnovember)
    modal.find('.modal-body input[name="desember"]').val(revdesember)
})

$('#karyawanUbah').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var npk = button.data('npk') // Extract info from data-* attributes
    var nama = button.data('nama')
    var inisial = button.data('inisial')
    var email = button.data('email')
    var phone = button.data('phone')
    var foto = button.data('foto')
    var posisi = button.data('posisi')
    var modal = $(this)
    modal.find('.modal-body input[name="npk"]').val(npk)
    modal.find('.modal-body input[name="inisial"]').val(inisial)
    modal.find('.modal-body input[name="nama"]').val(nama)
    modal.find('.modal-body input[name="email"]').val(email)
    modal.find('.modal-body input[name="phone"]').val(phone)
    modal.find('.modal-body [name="foto"]').src = foto
    modal.find('.modal-body select[name="posisi"]').val(posisi)
})

$('#tambahPeserta').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(id)
})

$('#batalRsv').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(id)
})

$('#batalDl').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(id)
})

$('#revisiPerjalanan').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(id)
})

$('#editPerjalanan').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(id)
})

$('#aktivitasModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var copro = button.data('copro') // Extract info from data-* attributes
    var id = button.data('id') // Extract info from data-* attributes
    var milestone = button.data('milestone') // Extract info from data-* attributes
    var aktivitas = button.data('aktivitas') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="copro"]').val(copro)
    modal.find('.modal-body input[name="id"]').val(id)
    modal.find('.modal-body input[name="milestone"]').val(milestone)
    modal.find('.modal-body input[name="aktivitas"]').val(aktivitas)
})

