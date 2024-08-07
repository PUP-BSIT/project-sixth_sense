document.addEventListener("DOMContentLoaded", function() {
  const addTaskButton = document.getElementById("add-task");
  const sortNewest = document.getElementById("sort-newest");
  const sortOldest = document.getElementById("sort-oldest");
  const sortNewestCompleted = document.getElementById("sort-newest-completed");
  const sortOldestCompleted = document.getElementById("sort-oldest-completed");
  const closeButton = document.querySelector(".close");
  const saveTaskButton = document.getElementById("save-task");

  if (addTaskButton) {
    addTaskButton.addEventListener("click", addTask);
  }
  if (sortNewest) {
    sortNewest.addEventListener("click", () => sortTasks("tasks", "newest"));
  }
  if (sortOldest) {
    sortOldest.addEventListener("click", () => sortTasks("tasks", "oldest"));
  }
  if (sortNewestCompleted) {
    sortNewestCompleted.addEventListener("click", () => sortTasks("completed-tasks", "newest"));
  }
  if (sortOldestCompleted) {
    sortOldestCompleted.addEventListener("click", () => sortTasks("completed-tasks", "oldest"));
  }
  if (closeButton) {
    closeButton.addEventListener("click", closeModal);
  }
  if (saveTaskButton) {
    saveTaskButton.addEventListener("click", saveTask);
  }

  fetchTasks();
});

let currentTask;

function addTask() {
  const taskInput = document.getElementById("task-input");
  const taskText = taskInput.value.trim();
  if (taskText !== "") {
    saveTaskToDatabase(Date.now(), taskText, "not_done");
    taskInput.value = "";
  }
}

function saveTaskToDatabase(toDoId, taskText, done) {
  fetch('to_do_entry.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ to_do_id: toDoId, assigned: taskText, done: done })
  })
  .then(response => response.text())
  .then(text => {
    console.log('Raw response:', text);
    try {
      const data = JSON.parse(text);
      if (data.success) {
        fetchTasks();
      } else {
        console.error('Failed to save task to database:', data.error);
      }
    } catch (error) {
      console.error('Error parsing JSON:', error);
    }
  })
  .catch(error => console.error('Error:', error));
}

function fetchTasks() {
  fetch('to_do_entry.php')
  .then(response => response.text())
  .then(text => {
    console.log('Raw response:', text);
    try {
      const data = JSON.parse(text);
      if (data.success) {
        renderTasks(data.data);
      } else {
        console.error('Failed to fetch tasks:', data.error);
      }
    } catch (error) {
      console.error('Error parsing JSON:', error);
    }
  })
  .catch(error => console.error('Error:', error));
}

function renderTasks(tasks) {
  const taskList = document.getElementById("task-list");
  const completedTaskList = document.getElementById("completed-task-list");
  taskList.innerHTML = '';
  completedTaskList.innerHTML = '';

  tasks.forEach(task => {
    const taskElement = createTaskElement(task.to_do_id, task.assigned, task.time_created, task.done === 'done');
    if (task.done === 'done') {
      completedTaskList.appendChild(taskElement);
    } else {
      taskList.appendChild(taskElement);
    }
  });
}

function createTaskElement(id, text, timestamp, isCompleted = false) {
  const task = document.createElement("div");
  task.className = "task";
  task.dataset.timestamp = new Date(timestamp).getTime();
  task.dataset.id = id;
  task.innerHTML = `
        <span>${text}</span>
        <div class="task-actions">
            ${isCompleted ? '' : '<button class="done">Done</button>'}
            <button class="edit">Edit</button>
            <button class="delete">Delete</button>
        </div>
        <div class="timestamp">${new Date(timestamp).toLocaleString()}</div>
    `;

  if (!isCompleted) {
    task.querySelector(".done").addEventListener("click", () => updateTaskStatus(task, 'done'));
  }
  task.querySelector(".edit").addEventListener("click", () => openEditModal(task));
  task.querySelector(".delete").addEventListener("click", () => deleteTask(task));

  return task;
}

function updateTaskStatus(task, status) {
  const id = task.dataset.id;
  const text = task.querySelector("span").innerText;
  saveTaskToDatabase(id, text, status);
}

function openEditModal(task) {
  currentTask = task;
  const modalTaskInput = document.getElementById("modal-task-input");
  if (modalTaskInput) {
    modalTaskInput.value = task.querySelector("span").innerText;
    document.getElementById("editModal").style.display = "block";
  } else {
    console.error("Modal task input element not found");
  }
}

function closeModal() {
  document.getElementById("editModal").style.display = "none";
}

function saveTask() {
  const newText = document.getElementById("modal-task-input").value.trim();
  if (newText !== "") {
    const id = currentTask.dataset.id;
    currentTask.querySelector("span").innerText = newText;
    saveTaskToDatabase(id, newText, 'not_done');
    closeModal();
  }
}

function deleteTask(task) {
  const id = task.dataset.id;
  fetch('to_do_entry.php', {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ to_do_id: id })
  })
  .then(response => response.text())
  .then(text => {
    console.log('Raw response:', text);
    try {
      const data = JSON.parse(text);
      if (data.success) {
        task.remove();
      } else {
        console.error('Failed to delete task from database:', data.error);
      }
    } catch (error) {
      console.error('Error parsing JSON:', error);
    }
  })
  .catch(error => console.error('Error:', error));
}

function sortTasks(containerId, order) {
  const container = document.getElementById(containerId === "tasks" ? "task-list" : "completed-task-list");
  const tasks = Array.from(container.children);
  tasks.sort((a, b) => {
    const timeA = parseInt(a.dataset.timestamp);
    const timeB = parseInt(b.dataset.timestamp);
    return order === "newest" ? timeB - timeA : timeA - timeB;
  });
  tasks.forEach((task) => container.appendChild(task));
}
