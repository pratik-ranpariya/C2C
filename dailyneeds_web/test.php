<html lang=en>
  <head>
    <meta charset=utf-8>
    <title>Chatkit demo</title>
  </head>
  <body>
    <ul id="message-list"></ul>
    <form id="message-form">
      <input type='text' id='message-text'>
      <input type="submit">
    </form>

    <script src="https://unpkg.com/@pusher/chatkit/dist/web/chatkit.js"></script>
    <script>
      const tokenProvider = new Chatkit.TokenProvider({
        url: "https://us1.pusherplatform.io/services/chatkit_token_provider/v1/3eac81fd-aad1-4eb7-9e0e-48fe5c214549/token"
      });
      const chatManager = new Chatkit.ChatManager({
        instanceLocator: "v1:us1:3eac81fd-aad1-4eb7-9e0e-48fe5c214549",
        userId: "test11",
        tokenProvider: tokenProvider
      });

      chatManager
        .connect()
        .then(currentUser => {
          currentUser.subscribeToRoom({
            roomId: 16730450,
            hooks: {
              onNewMessage: message => {
                const ul = document.getElementById("message-list");
                const li = document.createElement("li");
                li.appendChild(
                  document.createTextNode(`${message.senderId}: ${message.text}`)
                );
                ul.appendChild(li);
              }
            }
          });

          const form = document.getElementById("message-form");
          form.addEventListener("submit", e => {
            e.preventDefault();
            const input = document.getElementById("message-text");
            currentUser.sendMessage({
              text: input.value,
              roomId: currentUser.rooms[0].id
            });
            input.value = "";
          });
        })
        .catch(error => {
          console.log("error:", error);
        });
    </script>
  </body>
</html>