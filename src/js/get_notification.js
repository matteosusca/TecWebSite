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

// Example usage: get the notifications and log them to the console
getNotifications().then((notifications) => {
  console.log(notifications);
});
