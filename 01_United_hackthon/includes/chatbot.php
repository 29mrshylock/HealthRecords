<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Healthcare Chatbot</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <style>
    /* [Same CSS, no changes needed] */
    * {
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #e3f2fd;
    }

    .chatbot-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 50%;
      padding: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

    .chatbot-toggle span {
      position: absolute;
      transition: opacity 0.3s ease;
    }

    .show-chatbot .chatbot-toggle span:first-child,
    .chatbot-toggle span:last-child {
      opacity: 0;
    }

    .show-chatbot .chatbot-toggle span:last-child {
      opacity: 1;
    }

    .chatbot {
      position: fixed;
      bottom: 90px;
      right: 30px;
      width: 350px;
      max-height: 500px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      display: none;
      flex-direction: column;
    }

    .show-chatbot .chatbot {
      display: flex;
    }

    .chatbot header {
      background-color: #724ae8;
      padding: 16px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .chatbot header h2 {
      color: #fff;
      font-size: 1.3rem;
      margin-top: 8px;
    }

    .bot-avatar {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: white;
      padding: 4px;
    }

    .chatbot .chatbox {
      flex: 1;
      overflow-y: auto;
      padding: 20px 20px 80px;
    }

    .chatbox .chat {
      display: flex;
      margin: 20px 0;
    }

    .chatbox .chat p {
      background: #724ae8;
      max-width: 75%;
      color: white;
      padding: 12px 16px;
      border-radius: 12px 12px 0 12px;
      font-size: 0.95rem;
      word-wrap: break-word;
      white-space: pre-wrap;
    }

    .chatbox .incoming p {
      color: #000;
      background: #f2f2f2;
      border-radius: 12px 12px 12px 0;
    }

    .chatbox .incoming span {
      height: 32px;
      width: 32px;
      background: #724ae8;
      align-self: flex-end;
      color: white;
      text-align: center;
      line-height: 32px;
      border-radius: 4px;
      margin: 0 10px 7px 0;
    }

    .chatbox .outgoing {
      justify-content: flex-end;
    }

    .chatbot .chat-input {
      position: relative;
      bottom: 0;
      display: flex;
      gap: 5px;
      width: 100%;
      background: #fff;
      padding: 5px 20px;
      border-top: 1px solid #ccc;
    }

    .chat-input textarea {
      height: 55px;
      width: 100%;
      border: none;
      outline: none;
      font-size: 0.95rem;
      resize: none;
      padding: 16px 15px 16px 0;
    }

    .chat-input span {
      color: #724ae8;
      font-size: 1.35rem;
      cursor: pointer;
      align-self: flex-end;
      height: 55px;
      line-height: 55px;
      visibility: hidden;
    }

    .chat-input textarea:valid~span {
      visibility: visible;
    }
  </style>
</head>

<body class="show-chatbot">

  <button class="chatbot-toggle">
    <img src="img/chatbot.jpg" alt="Assistant" class="bot-avatar">
  </button>

  <div class="chatbot">
    <header>
      <h2>Health Assistant</h2>
    </header>
    <ul class="chatbox">
      <li class="chat incoming">
        <span class="material-symbols-outlined">smart_toy</span>
        <p>Hi there!<br />How can I help you today?</p>
      </li>
    </ul>
    <div class="chat-input">
      <textarea placeholder="Enter a message..." required></textarea>
      <span id="send-btn" class="material-symbols-outlined">send</span>
    </div>
  </div>
  <script>
    const chatBox = document.querySelector(".chatbox");
    const chatInput = document.querySelector(".chat-input textarea");
    const sendBtn = document.querySelector("#send-btn");
    const toggleBtn = document.querySelector(".chatbot-toggle");
    const body = document.body;

    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("show-chatbot");
    });

    const createChatLi = (message, className) => {
      const chatLi = document.createElement("li");
      chatLi.classList.add("chat", className);
      let content = className === "outgoing"
        ? `<p>${message}</p>`
        : `<span class="material-symbols-outlined">smart_toy</span><p>${message}</p>`;
      chatLi.innerHTML = content;
      return chatLi;
    };

    async function generateBotResponse(userMessage) {
      const specialties = [
        "cardiology", "dermatology", "neurology", "pediatrics", "orthopedics",
        "psychiatry", "gastroenterology", "pulmonology", "endocrinology", "ophthalmology",
        "ent", "urology", "nephrology", "oncology", "rheumatology", "general surgery",
        "gynecology", "dentistry", "infectious disease", "immunology", "allergy",
        "hematology", "plastic surgery", "vascular surgery", "sports medicine", "pain management"
      ];

      const symptomTospecilaty = {
        "chest pain": "cardiology",
        "heart palpitations": "cardiology",
        "skin rash": "dermatology",
        "acne": "dermatology",
        "headache": "neurology",
        "migraine": "neurology",
        "child fever": "pediatrics",
        "joint pain": "orthopedics",
        "broken bone": "orthopedics",
        "anxiety": "psychiatry",
        "depression": "psychiatry",
        "stomach ache": "gastroenterology",
        "indigestion": "gastroenterology",
        "shortness of breath": "pulmonology",
        "cough": "pulmonology",
        "thyroid problems": "endocrinology",
        "eye pain": "ophthalmology",
        "vision loss": "ophthalmology",
        "ear infection": "ent",
        "hearing loss": "ent",
        "urinary infection": "urology",
        "kidney pain": "nephrology",
        "blood in urine": "nephrology",
        "lump or tumor": "oncology",
        "swollen joints": "rheumatology",
        "hernia": "general surgery",
        "pregnancy care": "gynecology",
        "toothache": "dentistry",
        "sore throat": "infectious disease",
        "allergic reaction": "allergy",
        "low blood count": "hematology",
        "burn injury": "plastic surgery",
        "varicose veins": "vascular surgery",
        "sports injury": "sports medicine",
        "chronic pain": "pain management"
      };

      const lowerCaseMessage = userMessage.toLowerCase();
      let matchedspecilaty = specialties.find(spec => lowerCaseMessage.includes(spec));

      if (!matchedspecilaty) {
        for (const symptom in symptomTospecilaty) {
          if (lowerCaseMessage.includes(symptom)) {
            matchedspecilaty = symptomTospecilaty[symptom];
            break;
          }
        }
      }

      if (matchedspecilaty) {
        try {
          const response = await fetch('chatbotphp.php');
          const doctors = await response.json();
          const filteredDoctors = doctors.filter(doc => doc.specilaty.toLowerCase() === matchedspecilaty);

          if (filteredDoctors.length > 0) {
            let doctorsList = `<b>🩺 Based on your symptoms, here are available doctors:</b><br><br>`;
            filteredDoctors.forEach(doctor => {
              doctorsList += `
            <div style="margin-bottom: 12px; padding: 15px; border: 1px solid #e0e0e0; border-radius: 15px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
              <a href="doctor_profile.php?id=${doctor.id}" target="_blank" style="font-weight:bold; font-size: 1.1rem; color:#007bff; text-decoration:none;">
                🧑‍⚕️ Dr. ${doctor.fullname}
              </a><br><br>
              <span style="font-size: 0.9rem;">🔬 <b>specilaty:</b> ${doctor.specilaty}</span><br>
              <span style="font-size: 0.9rem;">📅 <b>Days:</b> ${doctor.availability_days}</span><br>
              <span style="font-size: 0.9rem;">⏰ <b>Time:</b> ${doctor.availability_time}</span>
            </div>
          `;
            });
            return doctorsList;
          } else {
            return `😔 No doctors available for ${capitalizeFirstLetter(matchedspecilaty)}.`;
          }
        } catch (error) {
          console.error(error);
          return "⚠️ Error fetching doctor data.";
        }
      }

      if (lowerCaseMessage.includes("book") || lowerCaseMessage.includes("appointment") || lowerCaseMessage.includes("schedule")) {
        return `📅 You can book an appointment here: <a href='appointment_form.php' target='_blank' style="color: #724ae8;">Book Now</a>`;
      }

      if (["hi", "hello", "hey"].some(greet => lowerCaseMessage.includes(greet))) {
        return "Hello! 👋 How can I assist you today?";
      }

      if (lowerCaseMessage.includes("thank")) {
        return "You're welcome! 😊";
      }

      if (lowerCaseMessage.includes("bye") || lowerCaseMessage.includes("goodbye")) {
        return "Goodbye! 👋 Take care!";
      }

      return "🤔 Sorry, I didn't understand. Try asking about symptoms, doctors, booking appointments, or reports.";
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    const handleChat = async () => {
      let userMessage = chatInput.value.trim();
      if (!userMessage) return;

      chatBox.appendChild(createChatLi(userMessage, "outgoing"));
      chatBox.scrollTop = chatBox.scrollHeight;
      chatInput.value = "";

      const typingLi = createChatLi("Typing...", "incoming");
      chatBox.appendChild(typingLi);
      chatBox.scrollTop = chatBox.scrollHeight;

      const botReply = await generateBotResponse(userMessage);

      setTimeout(() => {
        typingLi.querySelector("p").innerHTML = botReply;
        chatBox.scrollTop = chatBox.scrollHeight;
      }, 600);
    };

    sendBtn.addEventListener("click", handleChat);

    chatInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        handleChat();
      }
    });
  </script>


</body>

</html>