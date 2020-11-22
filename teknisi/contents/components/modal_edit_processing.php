<!-- Modal -->
<div
    class="modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="ubah_processing"
    aria-hidden="true"
    id="modal_edit_processing"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubah_processing">Form Ubah Pengerjaan</h5>
                <button
                    class="btn-lg close"
                    data-dismiss="modal"
                    aria-label="Close"
                    style="margin-top: 0; margin-bottom: 0; padding-top: 6px; padding-bottom: 2px;"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="frmChange" method="POST" action="?content=pengerjaan_proses&proses=edit_processing">
                    <input type="hidden" name="id_pemesanan_detail" id="id_pemesanan_detail" value="">
                    <input type="hidden" name="id_pemesanan" id="id_pemesanan" value="">
                    <input type="hidden" name="id_kategori" id="id_kategori" value="">
                    <div class="">
                        <div class="todo-list">
                            <div class="tdl-holder">
                                <div class="tdl-content">
                                    <ul>
                                        <div class="accordion" id="accordion">
                                            <!-- Total Biaya -->
                                            <!--
                                            <div class="card-header border-right border-left border-top">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="mb-0 text-primary" style="text-">
                                                            Total Biaya
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-right" id='currency-total-biaya'>Rp 0</label>
                                                        <input type="hidden" value="0" name="total-biaya" id="total-biaya" onchange="getCurrency();">
                                                    </div>
                                                </div>
                                            </div>
                                            -->
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mt-3">
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>