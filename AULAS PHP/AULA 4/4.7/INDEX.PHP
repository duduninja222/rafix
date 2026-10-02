<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Placar de Futebol</title>
</head>
<body>

    <h1>Placar de Futebol</h1>

    <input type="text" id="time1" placeholder="Primeiro time">
    <input type="number" id="gols1" placeholder="Gols">

    <br><br>

    <input type="text" id="time2" placeholder="Segundo time">
    <input type="number" id="gols2" placeholder="Gols">

    <br><br>

    <button onclick="calcular()">Ver resultado</button>

    <h2 id="resultado"></h2>

    <script>
        function calcular() {
            let time1 = document.getElementById("time1").value;
            let time2 = document.getElementById("time2").value;

            let gols1 = Number(document.getElementById("gols1").value);
            let gols2 = Number(document.getElementById("gols2").value);

            if (gols1 > gols2) {
                document.getElementById("resultado").innerHTML = "Vitória do " + time1;
            } else if (gols2 > gols1) {
                document.getElementById("resultado").innerHTML = "Vitória do " + time2;
            } else {
                document.getElementById("resultado").innerHTML = "Empate!";
            }
        }
    </script>

</body>
</html>