// Define the API endpoint for retrieving notifications
const API_ENDPOINT = 'api_get_notifications.php';

// Function to get the notifications for the logged in user
async function getNotifications() {
    try {
        // Make a GET request to the API endpoint
        const response = await axios.get(API_ENDPOINT);

        // Extract the notifications from the response data
        const notifications = response.data;

        // Return the notifications
        return notifications;
    } catch (error) {
        console.error(error);
    }
}

function showNotifications() {
    getNotifications().then(notifications => {
    // Clear the existing notifications
        document.getElementById("notifications").innerHTML = "";
        document.getElementById("notification_counter").innerHTML = notifications.length;

        // Add the new notifications
        notifications.forEach(notification => {
                document.getElementById("notifications").appendChild(createNotification(notification));
        });
    });
}

showNotifications();

// Example usage: get the notifications and log them to the console
setInterval(() => {
    showNotifications();
}, 10000); // 30 seconds


function createNotification(notification) {
    // Create a new <a> element for the notification
    let notificationElement = document.createElement("a");
    notificationElement.classList.add("list-group-item", "list-group-item-action");
    notificationElement.setAttribute("data-bs-toggle", "modal");
  
    // Create a new <div> element for the notification content
    let contentElement = document.createElement("div");
    contentElement.classList.add("d-flex", "align-items-start", "position-relative");
  
    // Create a new <span> element for the timestamp
    let timestampElement = document.createElement("span");
    timestampElement.classList.add("position-absolute", "top-100", "end-0", "translate-middle-y");
    timestampElement.innerText = notification.date;
  
    // Create a new <img> element for the image
    let imageElement = document.createElement("img");
    imageElement.src = notification.img;
    imageElement.width = "64";
    imageElement.height = "64";
    imageElement.classList.add("rounded-circle");
  
    // Append the timestamp and image elements to the contentElement
    contentElement.appendChild(timestampElement);
    contentElement.appendChild(imageElement);
  
    // Append the contentElement to the notificationElement
    notificationElement.appendChild(contentElement);

    //switch per tipo di notifica
    switch(notification.type) {
        case "like":
            notificationElement.href = "post.php?id=" + notification.post_id;
            contentElement.innerHTML += notification.sender + " liked your post";
            break;
        case "comment":
            notificationElement.href = "post.php?id=" + notification.post_id;
            contentElement.innerHTML += notification.sender + " commented on your post";
            break;
        case "follow":
            //notificationElement.href = "profile.php?user=" + notification.sender;
            contentElement.innerHTML += notification.sender + " started following you";
            break;
        case "event":
            notificationElement.href = "event.php?id=" + notification.event_id;
            contentElement.innerHTML += notification.sender + " invited you to an event";
            break;
        case "post":
            notificationElement.href = "post.php?id=" + notification.post_id;
            contentElement.innerHTML += notification.sender + " posted something";
            break;
        case "friend_request":
            notificationElement.setAttribute("data-bs-target", "#modalNotification");
            //onclick, when the user clicks on the modal, change value of the hidden input with the sender username
            notificationElement.onclick = function() {
                //set sender_accept and sender_decline to the sender username
                document.getElementById("sender").value = notification.sender;
            }
            contentElement.innerHTML += notification.sender + " sent you a friend request";
            break;
    }
  
    // Add the text of the notification
  
    // Return the created notification element
    return notificationElement;
}
  

