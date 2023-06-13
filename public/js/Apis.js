const alertSwal = (message, icon) => {
  Swal.fire({
    "title": message,
    "timer": 5000,
    "width": "auto",
    "padding": "1.25rem",
    "showConfirmButton": false,
    "showCloseButton": true,
    "timerProgressBar": true,
    "toast": true,
    "icon": icon,
    "position": "bottom-end"
  });
}

const findByNameAndDelete = (name) => {
  document.querySelector('[data-userid="' + name + '"]').parentNode.parentNode.parentNode.remove()
}

const formatDataBr = (data) => {
  var partes = data.split('-');
  return partes[2] + '/' + partes[1] + '/' + partes[0];
}

const createButtonReset = () => {
  if (!document.getElementById("resetar")) {
    const button = document.createElement("button");
    button.id = "resetar";
    button.onclick = () => {
      location.reload();
    };
    button.className = "bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded";
    button.style.cssText = "color: white; background: #c7b34b; margin-right: 10px;";
    button.textContent = "Resetar";
    document.getElementById("botoes").appendChild(button);
  }
};

const inputsClean = () => {
  const inputs = Array.from(document.getElementsByTagName('input'));
  const selects = Array.from(document.getElementsByTagName('select'));

  inputs.forEach((input) => {
    if (input.name !== '_token') {
      input.value = '';
    }
  });

  selects.forEach((select) => {
    select.selectedIndex = 0;
  });
}

const apis = {

  delete: (id, redirect = false) => {
    const data = {
      user_id: id,
      _token: document.getElementsByName('_token')[0].value
    };

    if (data.user_id == "") {
      return alertSwal("Preencha todos os campos!", "error")
    }

    fetch('/api/clients/process/delete/' + data.user_id, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => {
        if (response.status === 204) {

          alertSwal('Usuário deletado com sucesso', 'success');

          if (redirect) {
            setTimeout(function () {
              window.location.href = "/clients";
            }, 2500);
            return;
          }

          return findByNameAndDelete(data.user_id);
        }
        alertSwal('Erro ao apagar o usuário', 'error');
      })
      .then(jsonData => {
        if (jsonData) {
          return alertSwal(jsonData.message, 'success');
        }
      })
      .catch(error => {
        alertSwal('Erro ao apagar o usuário', 'error');
        console.error('Ocorreu um erro:', error);
      });
  },

  pesquisa: (url = "/api/clients/process/list") => {
    const data = {
      nome: document.getElementById('nome').value,
      data_nascimento: document.getElementById('nascimento').value,
      sexo: document.querySelector('input[name="sexo"]:checked')?.value || "",
      cpf: document.getElementById('cpf').value,
      endereco: document.getElementById('endereco').value,
      cidade: document.getElementById('cidade').value,
      estado: document.getElementById('estado').value,
      _token: document.getElementsByName('_token')[0].value
    };

    if (
      data.nome == "" &&
      data.sexo == "" &&
      data.cpf == "" &&
      data.endereco == "" &&
      data.cidade == "Selecione um Estado" &&
      data.estado == "Selecione" &&
      data.data_nascimento == ""
    ) {
      return alertSwal("Voce deve inserir algum criterio!", "error")
    }

    if (data.estado == "Selecione") data.estado = ""
    if (data.cidade == "Selecione um Estado") data.cidade = ""

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(jsonData => {

        if (url != "/api/clients/process/list") {
          return addClientesTable(jsonData.data.data)
        }

        if (jsonData.data.data.length > 0) {
          addClientesTable(jsonData.data.data)
          createButtonReset()
          alertSwal(`Busca feita!`, "success")
          clientModal.navbar_numbers(jsonData.data.links)
          return;
        }

        alertSwal('Não foi encontrado nenhum cliente com base nesses criterios', "error")
      })
      .catch(error => {
        alertSwal('Erro interno, contate o suporte', "error")
        console.error('Ocorreu um erro:', error);
      });
  }

}

const clientModal = {

  tr: (data) => {
    var tbody = document.getElementById('clientes');
    var newRow = document.createElement('tr');
    var col1 = document.createElement('td');
    col1.style.width = '130px';
    var button1 = document.createElement('button');
    button1.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 rounded';
    button1.style.cssText = 'color: white; background: #00890c; width: 100px; font-size: 11px;';
    button1.textContent = 'Modificar';
    col1.appendChild(button1);
    var col2 = document.createElement('td');
    var div = document.createElement('div');
    var button2 = document.createElement('button');
    button2.setAttribute('data-userid', data.id);
    button2.name = 'delete';
    button2.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 rounded';
    button2.style.cssText = 'color: white; background: #bb0000; width: 100px; font-size: 11px;';
    button2.textContent = 'Deletar';
    button2.onclick = function () {
      apis.delete(data.id, false)
    };
    div.appendChild(button2);
    col2.appendChild(div);
    var col3 = document.createElement('td');
    col3.textContent = data.name
    var col4 = document.createElement('td');
    col4.textContent = data.cpf
    var col5 = document.createElement('td');
    col5.textContent = data.date_birth
    var col6 = document.createElement('td');
    col6.textContent = data.state
    var col7 = document.createElement('td');
    col7.textContent = data.city
    var col8 = document.createElement('td');
    col8.textContent = data.sex
    newRow.appendChild(col1);
    newRow.appendChild(col2);
    newRow.appendChild(col3);
    newRow.appendChild(col4);
    newRow.appendChild(col5);
    newRow.appendChild(col6);
    newRow.appendChild(col7);
    newRow.appendChild(col8);
    tbody.appendChild(newRow);
  },

  navbar_numbers: (data) => {
    var tbody = document.getElementById('pagination-numbers');
    if (document.getElementById('anterior') != null) {
      document.getElementById('anterior').remove();
    }
    tbody.innerHTML = '';
    data.forEach(element => {
      if (!isNaN(element.label)) {
        var elementoinserir = document.createElement('a');
        elementoinserir.href = "#";
        elementoinserir.onclick = function () {
          apis.pesquisa(element.url)
        };
        elementoinserir.className = "relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150";
        elementoinserir.setAttribute("aria-label", "Go to page " + element.label + "");
        elementoinserir.innerText = element.label
        tbody.appendChild(elementoinserir);
      }
    });
  }
}

const addClientesTable = (data) => {
  var tbody = document.getElementById('clientes');
  tbody.innerHTML = '';

  data.forEach(element => {
    clientModal.tr(element)
  });
}

if (document.getElementById('limpar') != null) {
  document.getElementById('limpar').addEventListener('click', function () {
    inputsClean()
  })
}

if (document.getElementById('login') != null) {
  document.getElementById('login').addEventListener('click', function () {

    const data = {
      username: document.getElementById('username').value,
      password: document.getElementById('password').value,
      _token: document.getElementsByName('_token')[0].value
    };

    if (data.username == "" || data.password == "") {
      return alertSwal("Preencha todos os campos!", "error")
    }

    fetch('/api/auth/process/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(jsonData => {
        if (jsonData.status === true) {
          return window.location.href = '/clients';
        }
        alertSwal(jsonData.message, "error")
      })
      .catch(error => {
        alertSwal('Erro interno, contate o suporte', "error")
        console.error('Ocorreu um erro:', error);
      });
  });
}

if (document.getElementById('addClient') != null) {
  document.getElementById('addClient').addEventListener('click', function () {

    const data = {
      nome: document.getElementById('nome').value,
      nascimento: document.getElementById('nascimento').value,
      sexo: document.querySelector('input[name="sexo"]:checked')?.value || "",
      cpf: document.getElementById('cpf').value,
      endereco: document.getElementById('endereco').value,
      cidade: document.getElementById('cidade').value,
      estado: document.getElementById('estado').value,
      _token: document.getElementsByName('_token')[0].value
    };

    if (
      data.nome == "" ||
      data.sexo == "" ||
      data.cpf == "" ||
      data.endereco == "" ||
      data.cidade == "" ||
      data.estado == "" ||
      data.nascimento == ""
    ) {
      return alertSwal("Preencha todos os campos!", "error")
    }

    fetch('/api/clients/process/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(jsonData => {
        if (jsonData.status === true) {
          return alertSwal(jsonData.message, "success")
        }
        alertSwal(jsonData.message, "error")
      })
      .catch(error => {
        alertSwal('Erro interno', "error")
        console.error('Ocorreu um erro:', error);
      });
  });
}

if (document.getElementById('editClient') != null) {
  document.getElementById('editClient').addEventListener('click', function () {

    const data = {
      nome: document.getElementById('nome').value,
      nascimento: formatDataBr(document.getElementById('nascimento').value),
      sexo: document.querySelector('input[name="sexo"]:checked')?.value || "",
      cpf: document.getElementById('cpf').value,
      endereco: document.getElementById('endereco').value,
      cidade: document.getElementById('cidade').value,
      estado: document.getElementById('estado').value,
      _token: document.getElementsByName('_token')[0].value
    };

    if (
      data.nome == "" ||
      data.sexo == "" ||
      data.cpf == "" ||
      data.endereco == "" ||
      data.cidade == "" ||
      data.estado == "" ||
      data.nascimento == ""
    ) {
      return alertSwal("Preencha todos os campos!", "error")
    }

    fetch('/api/clients/process/edit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(jsonData => {
        if (jsonData.status === true) {
          return alertSwal(jsonData.message, "success")
        }
        alertSwal(jsonData.message, "error")
      })
      .catch(error => {
        alertSwal('Erro interno', "error")
        console.error('Ocorreu um erro:', error);
      });
  });
}

if (document.getElementById('Pesquisar') != null) {
  document.getElementById('Pesquisar').addEventListener('click', function () {
    apis.pesquisa()
  });
}
