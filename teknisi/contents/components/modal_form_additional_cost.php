<!-- Modal -->
<div
    class="modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="header_additional_cost"
    aria-hidden="true"
    id="modal_form_additional_cost"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header_additional_cost">Form Biaya Tambahan</h5>
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
                <form class="form-horizontal" name="frmChange" method="POST" action="?content=pengerjaan_proses&proses=edit_additional_cost" id="form_biaya_tambahan">
                    <input type="hidden" name="id_biaya_tambahan" id="id_biaya_tambahan" value="">
                    <input type="hidden" name="id_array" id="id_array" value="">
                    <div class="form-group">
                        <label class="col-form-label" for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukan Keterangan...">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="jumlah">Jumlah (Rp)</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" min="0" placeholder="Masukan Jumlah atau Nominal...">
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