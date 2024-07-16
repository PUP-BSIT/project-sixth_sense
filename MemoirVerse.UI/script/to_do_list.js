document.getElementById('add-task').addEventListener('click', addTask);
document.getElementById('sort-newest').addEventListener('click', () => sortTasks('tasks', 'newest'));
document.getElementById('sort-oldest').addEventListener('click', () => sortTasks('tasks', 'oldest'));
document.getElementById('sort-newest-completed').addEventListener('click', () => sortTasks('completed-tasks', 'newest'));
document.getElementById('sort-oldest-completed').addEventListener('click', () => sortTasks('completed-tasks', 'oldest'));

function addTask() {
    const taskInput = document.getElementById('task-input');
    const taskText = taskInput.value.trim();
    if (taskText !== '') {
        const taskList = document.getElementById('task-list');
        const taskElement = createTaskElement(taskText, new Date().toLocaleString());
        taskList.appendChild(taskElement);
        taskInput.value = '';
    }
}

function createTaskElement(text, timestamp) {
    const task = document.createElement('div');
    task.className = 'task';
    task.dataset.timestamp = new Date(timestamp).getTime();
    task.innerHTML = `
        <span>${text}</span>
        <span>${timestamp}</span>
        <div>
            <button class="done">Done</button>
            <button class="edit">Edit</button>
            <button class="delete">Delete</button>
        </div>
    `;

    task.querySelector('.done').addEventListener('click', () => moveToCompleted(task));
    task.querySelector('.edit').addEventListener('click', () => editTask(task));
    task.querySelector('.delete').addEventListener('click', () => deleteTask(task));

    return task;
}

function moveToCompleted(task) {
    const completedTasks = document.getElementById('completed-task-list');
    task.querySelector('.done').remove();
    completedTasks.appendChild(task);
}

function editTask(task) {
    const newText = prompt('Edit your task:', task.querySelector('span').innerText);
    if (newText !== null && newText.trim() !== '') {
        task.querySelector('span').innerText = newText.trim();
    }
}

function deleteTask(task) {
    task.remove();
}

function sortTasks(containerId, order) {
    const container = document.getElementById(containerId === 'tasks' ? 'task-list' : 'completed-task-list');
    const tasks = Array.from(container.children);
    tasks.sort((a, b) => {
        const timeA = parseInt(a.dataset.timestamp);
        const timeB = parseInt(b.dataset.timestamp);
        return order === 'newest' ? timeB - timeA : timeA - timeB;
    });
    tasks.forEach(task => container.appendChild(task));
}