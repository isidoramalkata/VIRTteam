<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"></button>
            <h4 class="modal-title">Izmenite predavaca
            </h4>
        </div>
        <div class="modal-body">
            <input class="form-control" type="text" placeholder="Ime" id="ime" name="ime" value="<?php echo $predavac['ime'] ?>">
            <input class="form-control" type="text" placeholder="Prezime" id="prezime" value="<?php echo $predavac['prezime'] ?>" >
            <input class="form-control" type="text" placeholder="E-Mail" id="email" value="<?php echo $predavac['email'] ?>" >
            <input class="form-control" type="text" placeholder="Katedra" id="katedra" value="<?php echo $predavac['katedra'] ?>" >
            <input class="form-control" type="text" placeholder="Godina zaposlenja" id="godinaZaposlenja" value="<?php echo $predavac['godinaZaposlenja'] ?>" >
            <input class="form-control" type="text" placeholder="Zvanje" id="zvanje" value="<?php echo $predavac['zvanje'] ?>" >
            <textarea class="form-control share-text" placeholder="Opis" id="opis" value="<?php echo $predavac['opis'] ?> " style="height: 100px"><?php echo $predavac['opis'] ?></textarea>

        </div>
        <div class="modal-footer">
            <a class="btn btn-white" onclick="sacuvaj_izmenu_predavaca('<?php echo $predavac['idPred']?>',<?php echo $tip?>);">Sacuvaj</a>
            <a class="btn btn-white" onclick="$('#toggle_modal').modal('hide');">Odustani</a>
        </div>
    </div>
</div>

<script>
    function sacuvaj_izmenu_predavaca(idPred,tip) {
        var ime = document.getElementById("ime").value;
        var prezime = document.getElementById("prezime").value;
        var email = document.getElementById("email").value;
        var katedra = document.getElementById("katedra").value;
        var godinaZaposlenja = document.getElementById("godinaZaposlenja").value;
        var zvanje = document.getElementById("zvanje").value;
        var opis = document.getElementById("opis").value;
        var idPred=idPred;
        $.ajax({
            type: 'POST',
            async: false,
            url: '<?php echo site_url()?>/moderator/edit_predavac',
            data: {ime:ime, prezime:prezime, email:email, katedra:katedra, godinaZaposlenja:godinaZaposlenja, zvanje:zvanje, idPred: idPred, opis:opis, tip:tip},
            success: function (returnData) {
                $('#nesto').html(returnData);
            }
        });
        $('#toggle_modal').modal('hide');
    }
</script>