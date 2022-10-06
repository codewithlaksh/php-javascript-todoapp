const showAlert = function(status, message) {
    let messageElem = document.getElementById("message");
    if (status == "error") {
        messageElem.setAttribute("class", "alert alert-danger");
        messageElem.innerHTML = "<strong>Error:</strong>\t";
    }
    else if (status == "success") {
        messageElem.setAttribute("class", "alert alert-success");
        messageElem.innerHTML = "<strong>Success:</strong>\t";
    }
    messageElem.innerHTML += message;
    setTimeout(() => {
        messageElem.setAttribute("class", "");
        messageElem.removeAttribute("class");
        messageElem.innerHTML = "";
    }, 2000);
}

const getTodos = function () {
    fetch('gettodos.php?gettodos=true')
    .then(res => res.json())
    .then(data => {
        if (data.length != 0) {
            let todos = data.map((todo, index) => {
                return `<tr>
                    <td>${index+1}</td>
                    <td>${todo.title}</td>
                    <td>${todo.description}</td>
                    <td>
                        <button class="edit btn btn-sm btn-danger" id="${todo.sno}">Edit</button>
                        <button class="delete btn btn-sm btn-danger" id="${todo.sno}">Delete</button>
                    </td>
                </tr>`;
            }).join("");
    
            document.getElementById("tbody").innerHTML = todos;
    
            for (key in data) {
                let editBtn = document.getElementsByClassName('edit')[key];
                let deleteBtn = document.getElementsByClassName('delete')[key];
                editBtn.addEventListener('click', (e) => {
                    let btnID = e.target.id;
                    getTodo(btnID);
                })
                deleteBtn.addEventListener('click', (e) => {
                    let btnID = e.target.id;
                    deleteTodo(btnID);
                })
            }
        }else{
            document.getElementById("tbody").innerHTML = `<tr>
                <td></td>
                <td></td>
                <td class="text-center">No data available in the table</td>
                <td></td>
            </tr>`;
        }
    });
}

let submitBtn = document.querySelector("button#submitBtn");
submitBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("title", document.querySelector("input#title").value);
    formData.append("description", document.querySelector("textarea#description").value);
    formData.append("type", "addtodo");
    fetch('main.php', {
        method: "post",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        showAlert(data[0].status, data[0].message);
        if (data[0].status == "success") {
            document.querySelector("input#title").value = "";
            document.querySelector("textarea#description").value = "";
            getTodos();
        } 
    })
})

let editBtns = document.getElementsByClassName('edit');
let deleteBtns = document.getElementsByClassName('delete');

Array.from(editBtns).forEach((element) => {
    element.addEventListener('click', (e) => {
        let btnID = e.target.id;
        getTodo(btnID);
    })
})
Array.from(deleteBtns).forEach((element) => {
    element.addEventListener('click', (e) => {
        let btnID = e.target.id;
        deleteTodo(btnID);
    })
})

const getTodo = function (todoID) {
    fetch(`gettodo.php?todo_sno=${todoID}`)
    .then(res => res.json())
    .then(data => {
        let snoEdit = document.getElementById('snoEdit');
        let titleEdit = document.getElementById('titleEdit');
        let descriptionEdit = document.getElementById('descriptionEdit');

        snoEdit.value = data[0].sno;
        titleEdit.value = data[0].title;
        descriptionEdit.value = data[0].description;
        $('#editModal').modal('toggle');
    })
}

let closeModalBtns = document.getElementsByClassName('closeModal');
Array.from(closeModalBtns).forEach((element) => {
    element.addEventListener('click', () => {
        document.getElementById('edit-todo-form').reset();
        document.getElementById('snoEdit').value = "";
        $('#editModal').modal('hide');
    })
})

let updateBtn = document.getElementById("updateBtn");
updateBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('snoEdit', document.getElementById('snoEdit').value);
    formData.append('titleEdit', document.getElementById('titleEdit').value);
    formData.append('descriptionEdit', document.getElementById('descriptionEdit').value);
    formData.append('type', 'updatetodo');

    fetch('main.php', {
        method: 'post',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        showAlert(data[0].status, data[0].message);
        if (data[0].status == "success") {
            document.getElementById('edit-todo-form').reset();
            document.getElementById('snoEdit').value = "";
            $('#editModal').modal('hide');
            getTodos();
        }
    })
})

const deleteTodo = function (todoID) {
    if (window.confirm("Are you sure, you want to delete this todo ?")) {
        const formData = new FormData();
        formData.append('snoDelete', todoID);
        formData.append('type', 'deletetodo');

        fetch('main.php', {
            method: 'post',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            showAlert(data[0].status, data[0].message);
            if (data[0].status == "success") {
                getTodos();
            }
        })
    }
}
