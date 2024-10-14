<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EncontrAqui</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto';
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body>
    <div class="content m-3 p-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <h2>EncontrAqui</h2>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <h5>Encontre empresas perto de você.</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12 alert alert-primary" role="alert">
                <h5>Por qual razão criei este site?</h5>
                <p>O Google se alimenta dos dados dos usuários, o usuário tem que explicitamente dizer que um lugar
                    existe, este site usa o banco de dados públicos de CNPJ fornecidos pelo governo federal</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">CEP</span>
                    </div>
                    <input type="number" class="form-control thisIsRetrieveableContent" aria-label="Default"
                        aria-describedby="inputGroup-sizing-default" id="cep">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">ou</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Endereço</span>
                    </div>
                    <input type="text" class="form-control thisIsRetrieveableContent" aria-label="Default"
                        aria-describedby="inputGroup-sizing-default" id="endereco">
                </div>
            </div>
            <div class="col-6">
                <select class="form-select thisIsRetrieveableContent" aria-label="Default select example" id="cnae">
                    <option selected value="">Selecione uma opção</option>
                    <option value="4530703">Comércio a varejo de peças e acessórios novos para veículos automotores
                    </option>
                </select>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary" onclick="getRes()">Pesquisar</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 border rounded" id="contentGoesHere"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12 border rounded" id="adGoesHere"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function getCNAEs() {
            url = 'http://localhost:1234/mockdapi.php';
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const selectElement = document.getElementById('cnae');
                    data.forEach(element => {
                        const option = document.createElement('option');
                        option.value = element.cnaeID;
                        option.textContent = element.cnaeDesc;
                        selectElement.appendChild(option);
                    });
                }).catch(err => {
                    selectElement = document.getElementById('cnae');
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = `Não pude trazer os CNAEs D: ${err}`;
                    selectElement.appendChild(option);
                });
        }
        function getContent() {
            const allContent = document.querySelectorAll('.thisIsRetrieveableContent');
            var sendToAPI = [];
            allContent.forEach(input => {
                if (input.value) {
                    sendToAPI[input.id] = input.value;
                }
            });
            return sendToAPI;
        }
        function getRes() {
            const url = 'http://localhost:1234/mockdapiactualres.php';
            const data = getContent();
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        data.forEach(element => {
                            var tableContent = '<table class="table"><thead><tr><th scope="col">Nome empresa</th><th scope="col">Endereço</th><th scope="col">Num</th><th scope="col">Complemento</th></tr></thead><tbody>';
                            data.forEach(element => {
                                tableContent += `
                            <tr>
                                <td scope="row">${element.nomeFantasia}</td>
                                <td>${element.logradouro}</td >
                                <td>${element.numero}</td>
                                <td>${element.complemento}</td>
                            </tr>
`;
                            });
                            tableContent += '</tbody></table>';
                            document.getElementById('contentGoesHere').innerHTML = tableContent;
                        })
                    } else {
                        const tableContent = `Data is mt!`
                        document.getElementById('contentGoesHere').innerHTML = tableContent;
                    }
                })
                .catch(err => {
                    var tableContent = `< table class="table"><thead><tr><th scope="row">Algo deu errado</th></tr></thead><tbody><tr><td scope="col">${err}</td></tr></tbody></table>`;
                    document.getElementById('contentGoesHere').innerHTML = tableContent;
                })
        }
        window.onload = function () {
            getCNAEs();
        }
    </script>
</body>

</html>