<!-- DELETE MODAL -->
<!-- Modal -->
<div data-backdrop="static" class="border-0 modal fade" id="deleteModal_<?= htmlspecialchars($etablissement['id']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border-0">
        <div class="modal-content border-0">
            <div class="modal-header" style="
              background: rgb(195, 98, 128);
              background: linear-gradient(
                261deg,
                rgba(195, 98, 128, 1) 33%,
                rgba(181, 50, 99, 0.9276844526873249) 62%
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
                <p class="text-center">
                    Etes-vous sûre de vouloir retirer cet établissement ?
                </p>
                <h2 class="text-center"><?= htmlspecialchars($etablissement['nom']) ?></h2>
            </div>
            <div class="modal-footer" style="
              background: rgb(195, 98, 128);
              background: linear-gradient(
                86deg,
                rgba(195, 98, 128, 1) 33%,
                rgba(181, 50, 99, 0.9276844526873249) 62%
              );
            ">
                <a href="controller/delete.php?id=<?= htmlspecialchars($etablissement['id']) ?>" type="button" class="btn btn-sm btn-primary">
                    <i class="fas fa-check fa-sm text-white-50"></i> Oui
                </a>
                <button class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fas fa-ban fa-sm text-white-50"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END OF DELETE MODAL -->