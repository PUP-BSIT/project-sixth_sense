document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('todo-input');
    const assignedTasks = document.getElementById('assigned-tasks');
    const doneTasks = document.getElementById('done-tasks');

    input.addEventListener('keypress', (event) => {
        if (event.key === 'Enter' && input.value.trim()) {
            addTask(input.value);
            input.value = '';
        }
    });

    function addTask(taskDescription) {
        const taskItem = document.createElement('div');
        taskItem.classList.add('task-item'); 

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.classList.add('task-checkbox');

        const taskContent = document.createElement('div');
        taskContent.classList.add('task-content');

        const taskText = document.createElement('span');
        taskText.textContent = taskDescription;

        const timestamp = document.createElement('span');
        timestamp.classList.add('task-timestamp');
        timestamp.textContent = new Date().toLocaleString();

        taskContent.appendChild(checkbox);
        taskContent.appendChild(taskText);
        taskContent.appendChild(timestamp);

        taskItem.appendChild(taskContent);

        assignedTasks.appendChild(taskItem);

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                doneTasks.appendChild(taskItem);
            } else {
                assignedTasks.appendChild(taskItem);
            }
        });
    }
});
