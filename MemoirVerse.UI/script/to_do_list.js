document.getElementById("add-task").addEventListener("click", addTask);
document.getElementById("sort-newest").addEventListener("click", () => sortTasks("tasks", "newest"));
document.getElementById("sort-oldest").addEventListener("click", () => sortTasks("tasks", "oldest"));
document.getElementById("sort-newest-completed").addEventListener("click", () => sortTasks("completed-tasks", "newest"));
document.getElementById("sort-oldest-completed").addEventListener("click", () => sortTasks("completed-tasks", "oldest"));

let currentTask;

function addTask() {
  const taskInput = document.getElementById("task-input");
  const taskText = taskInput.value.trim();
  if (taskText !== "") {
    const taskList = document.getElementById("task-list");
    const taskElement = createTaskElement(
      taskText,
      new Date().toLocaleString()
    );
    taskList.appendChild(taskElement);
    taskInput.value = "";
    saveTaskToDatabase(taskText, "assigned", "not_done");
  }
}

function saveTaskToDatabase(taskText, assigned, done) {
  const userId = "user123"; 
  const toDoId = Date.now(); 

  fetch('to_do_list.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ to_do_id: toDoId, user_id: userId, assigned: taskText, done: done })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Task saved to database');
    } else {
      console.error('Failed to save task to database:', data.error);
    }
  })
  .catch(error => console.error('Error:', error));
}

function createTaskElement(text, timestamp) {
  const task = document.createElement("div");
  task.className = "task";
  task.dataset.timestamp = new Date(timestamp).getTime();
  task.innerHTML = `
        <span>${text}</span>
        <div class="task-actions">
            <button class="done">Done</button>
            <button class="edit">Edit</button>
            <button class="delete">Delete</button>
        </div>
        <div class="timestamp">${timestamp}</div>
    `;

  task
    .querySelector(".done")
    .addEventListener("click", () => moveToCompleted(task));
  task
    .querySelector(".edit")
    .addEventListener("click", () => openEditModal(task));
  task
    .querySelector(".delete")
    .addEventListener("click", () => deleteTask(task));

  return task;
}

function moveToCompleted(task) {
  const completedTasks = document.getElementById("completed-task-list");
  task.querySelector(".done").remove();
  completedTasks.appendChild(task);
}

function openEditModal(task) {
  currentTask = task;
  document.getElementById("modal-task-input").value =
    task.querySelector("span").innerText;
  document.getElementById("editModal").style.display = "block";
}

function closeModal() {
  document.getElementById("editModal").style.display = "none";
}

function saveTask() {
  const newText = document.getElementById("modal-task-input").value.trim();
  if (newText !== "") {
    currentTask.querySelector("span").innerText = newText;
    closeModal();
  }
}

function deleteTask(task) {
  task.remove();
}

function sortTasks(containerId, order) {
  const container = document.getElementById(
    containerId === "tasks" ? "task-list" : "completed-task-list"
  );
  const tasks = Array.from(container.children);
  tasks.sort((a, b) => {
    const timeA = parseInt(a.dataset.timestamp);
    const timeB = parseInt(b.dataset.timestamp);
    return order === "newest" ? timeB - timeA : timeA - timeB;
  });
  tasks.forEach((task) => container.appendChild(task));
}

document.querySelector(".close").addEventListener("click", closeModal);
document.getElementById("save-task").addEventListener("click", saveTask);
window.addEventListener("click", (event) => {
  if (event.target == document.getElementById("editModal")) {
    closeModal();
  }
});
