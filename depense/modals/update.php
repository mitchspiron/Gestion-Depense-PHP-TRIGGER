<!-- MODAL EDIT -->
<!-- Modal -->
<div data-backdrop="static" class="border-0 modal fade" id="editModal_<?= htmlspecialchars($depense['id']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border-0">
        <form method="post" action="controller/update.php">
            <div class="modal-content border-0">
                <div class="modal-header" style="
                background: rgb(153, 223, 165);
                background: linear-gradient(
                  276deg,
                  rgba(153, 223, 165, 1) 33%,
                  rgba(50, 181, 144, 0.9276844526873249) 62%
                );
              ">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        MODIFICATION
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($depense['id']) ?>" />
                    <div class="form-group">
                        <label for="etab">Nom de l'établissement</label>
                        <select class="custom-select" class="form-control" id="etab" name="etab" placeholder="Choisissez l'établissement" required>
                            <?php
                            foreach ($etablissements as $etablissement) {
                            ?>
                                <option value="<?= htmlspecialchars($etablissement['id']) ?>"><?= htmlspecialchars($etablissement['nom']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="montant">Montant du dépense</label>
                        <input type="number" class="form-control" id="montant" name="montant" value="<?= htmlspecialchars($depense['montant']) ?>" placeholder="Entrez le montant de la dépense" min="0.00" max="1000000000000.00" step="0.01" required />
                    </div>
                </div>
                <div class="modal-footer" style="
                background: rgb(153, 223, 165);
                background: linear-gradient(
                  94deg,
                  rgba(153, 223, 165, 1) 33%,
                  rgba(50, 181, 144, 0.9276844526873249) 62%
                );
              ">
                    <button type="submit" name="edit" class="btn btn-sm btn-primary">
                        <i class="fas fa-check fa-sm text-white-50"></i> Enregister
                    </button>
                    <a class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fas fa-ban fa-sm text-white-50"></i> Fermer
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END OF EDIT MODAL -->