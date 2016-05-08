/**
 * This function enables the user to set the alarm clock of sandman
 * and disabel the alarm by solving a puzzle
 */

var http = require('http');

// URL to call with time the user wants to wake up
var setAlarmURL = "http://52.34.49.217:8000/api/config/set/wakeupat?value=";

// global var with puzzles for the sleepy person to solve
var puzzles = [
    {
        question: "what the fifth digit of pi is.",
        answer: "9"
    },
    {
        question: "what's two cubed?",
        answer: "8"
    },
    {
        question: "how many electoral votes does california have?",
        answer: "55"
    },
    {
        question: "what's the fourth planet from the sun?",
        answer: "mars"
    },
    {
        question: "what's the best flavor ice cream?",
        answer: "rocky road"
    }
];

// helper function to determine which question the user should iteract with
function getCurrentQuestion(session) {
    // if this value is set use it, otherwise default to zero
    if (session.hasOwnProperty('attributes')&& session.attributes.hasOwnProperty('questionCount')) {
        return session.attributes.questionCount;
    } else {
        return 0;
    }
}

// Route the incoming request based on type (LaunchRequest, IntentRequest,
// etc.) The JSON body of the request is provided in the event parameter.
exports.handler = function (event, context) {
    try {
        console.log("event.session.application.applicationId=" + event.session.application.applicationId);

        if (event.session.new) {
            onSessionStarted({requestId: event.request.requestId}, event.session);
        }

        if (event.request.type === "LaunchRequest") {
            onLaunch(event.request,
                event.session,
                function callback(sessionAttributes, speechletResponse) {
                    context.succeed(buildResponse(sessionAttributes, speechletResponse));
                });
        } else if (event.request.type === "IntentRequest") {
            onIntent(event.request,
                event.session,
                function callback(sessionAttributes, speechletResponse) {
                    context.succeed(buildResponse(sessionAttributes, speechletResponse));
                });
        } else if (event.request.type === "SessionEndedRequest") {
            onSessionEnded(event.request, event.session);
            context.succeed();
        }
    } catch (e) {
        context.fail("Exception: " + e);
    }
};

/**
 * Called when the session starts.
 */
function onSessionStarted(sessionStartedRequest, session) {
    console.log("onSessionStarted requestId=" + sessionStartedRequest.requestId +
        ", sessionId=" + session.sessionId);
}

/**
 * Called when the user launches the skill without specifying what they want.
 */
function onLaunch(launchRequest, session, callback) {
    console.log("onLaunch requestId=" + launchRequest.requestId +
        ", sessionId=" + session.sessionId);

    // Dispatch to your skill's launch.
    getWelcomeResponse(callback);
}

/**
 * Called when the user specifies an intent for this skill.
 */
function onIntent(intentRequest, session, callback) {
    console.log("onIntent requestId=" + intentRequest.requestId +
        ", sessionId=" + session.sessionId);

    var intent = intentRequest.intent,
        intentName = intentRequest.intent.name;

    // Dispatch to your skill's intent handlers
    if ("SetTimer" === intentName) {
        setTimer(intent, session, callback);
    } else if ("SilenceAlarm" === intentName) {
        silenceAlarm(intent, session, callback);
    } else if ("AnswerPuzzle" === intentName) {
        answerPuzzle(intent, session, callback);
    } else if ("AMAZON.HelpIntent" === intentName) {
        getWelcomeResponse(callback);
    } else if ("AMAZON.StopIntent" === intentName || "AMAZON.CancelIntent" === intentName) {
        handleSessionEndRequest(callback);
    } else {
        throw "Invalid intent";
    }
}

/**
 * Called when the user ends the session.
 * Is not called when the skill returns shouldEndSession=true.
 */
function onSessionEnded(sessionEndedRequest, session) {
    console.log("onSessionEnded requestId=" + sessionEndedRequest.requestId +
        ", sessionId=" + session.sessionId);
    // Add cleanup logic here
}

// --------------- Functions that control the skill's behavior -----------------------

function getWelcomeResponse(callback) {
    // If we wanted to initialize the session to have some attributes we could add those here.
    var sessionAttributes = {};
    var cardTitle = "Welcome";
    var speechOutput = "Welcome to sandman. " +
        "You can tell me when I should wake you up. Or you can just configure me";
    // If the user either does not reply to the welcome message or says something that is not
    // understood, they will be prompted again with this text.
    var repromptText = "I didn't understand a word, but we love the hoam hackathon from Academic works";
    var shouldEndSession = false;

    callback(sessionAttributes,
        buildSpeechletResponse(cardTitle, speechOutput, repromptText, shouldEndSession));
}

function handleSessionEndRequest(callback) {
    var cardTitle = "Session Ended";
    var speechOutput = "Well that was fun. Have a nice day!";
    // Setting this to true ends the session and exits the skill.
    var shouldEndSession = true;

    callback({}, buildSpeechletResponse(cardTitle, speechOutput, null, shouldEndSession));
}

/**
 * Sets the alarm to the time the user wants to wake up
 */
function setTimer(intent, session, callback) {
    var cardTitle = intent.name;
    var alarmTimeSlot = intent.slots.Time.value;
    var repromptText = "";
    var sessionAttributes = {};
    var shouldEndSession = false;
    var speechOutput = "";

    // TODO: check if valid time provided
    if (typeof alarmTimeSlot != 'undefined') {
        sessionAttributes = {
            alarmTime: alarmTimeSlot
        };
        speechOutput = "I will set the alarm to " + alarmTimeSlot + ". You can ask me " +
            "what time the alarm is set";
        repromptText = "You can ask me what time the alarm is set";
        http.get(setAlarmURL + alarmTimeSlot, function(res) {
          console.log('Got response: ' + res.statusCode);
          // consume response body
          var shouldEndSession = true;
          callback(sessionAttributes,
            buildSpeechletResponse(cardTitle, speechOutput, repromptText, shouldEndSession));
          res.resume();
            }).on('error', function(e) {
          console.log('Got error: ' + e.message);
        });
       
    } else {
        speechOutput = "I'm not sure what time I should wake you up tomorrow. You can set the alarm by saying wake me up at five pm";
        repromptText = "I'm not sure what time I should wake you up tomorrow. You can tell me the time " +
            "by saying, sandman, wake me up at five pm";
        callback(sessionAttributes,
            buildSpeechletResponse(cardTitle, speechOutput, repromptText, shouldEndSession));
    }
 
}

/**
 * This function tells the user they can turn off the alarm by solving a question
 */

function silenceAlarm(intent, session, callback) {
    var sessionAttributes = { questionCount: getCurrentQuestion(session) };
    var currentQuestion = puzzles[sessionAttributes.questionCount].question;
    var formatAnswerLike = ' You can can answer the question by saying, it is foo or the answer is bar';
    var repromptText = 'I didn\'t get that. I wanted to know ' + 
        currentQuestion + formatAnswerLike;
    var shouldEndSession = false;
    var speechOutput = "Here's the deal human. I'll turn off the alarm as soon as you tell me " + currentQuestion;

    // Setting repromptText to null signifies that we do not want to reprompt the user.
    // If the user does not respond or says something that is not understood, the session
    // will end.
    callback(sessionAttributes,
         buildSpeechletResponse(intent.name, speechOutput, repromptText, shouldEndSession));
}

/**
 * This function checks the user's answer and turns off the alarm (stops asking questions)
 * if the user gets the answer correct.
 */


function answerPuzzle(intent, session, callback) {
    var repromptText = ""; //'I didn\'t get that...' ;
    var sessionAttributes = {
        questionCount: getCurrentQuestion(session)
    };
    var shouldEndSession = false;
    var currentAnswer = puzzles[sessionAttributes.questionCount].answer;
    var userAnswer = intent.slots.Answer.value;
    var speechOutput = "";

    // Check if the users answer is correct
    // use soft equals to coerce types, yay JavaScript
    if (currentAnswer == userAnswer) {
        // end session which will tell the user they are correct
        speechOutput = "Air high five. Proceed to enjoy your day";
        shouldEndSession = true;
    } else {
        //tell the user the correct answer and move onto the next question
        sessionAttributes.questionCount += 1;
        var nextQuestion = puzzles[sessionAttributes.questionCount].question;
        speechOutput = "Oh no, the answer was " + currentAnswer + 
            ". Moving on; " + nextQuestion;

    }

    // Setting repromptText to null signifies that we do not want to reprompt the user.
    // If the user does not respond or says something that is not understood, the session
    // will end.
    callback(sessionAttributes,
         buildSpeechletResponse(intent.name, speechOutput, repromptText, shouldEndSession));
}


// --------------- Helpers that build all of the responses -----------------------

function buildSpeechletResponse(title, output, repromptText, shouldEndSession) {
    return {
        outputSpeech: {
            type: "PlainText",
            text: output
        },
        card: {
            type: "Simple",
            title: "SessionSpeechlet - " + title,
            content: "SessionSpeechlet - " + output
        },
        reprompt: {
            outputSpeech: {
                type: "PlainText",
                text: repromptText
            }
        },
        shouldEndSession: shouldEndSession
    };
}

function buildResponse(sessionAttributes, speechletResponse) {
    return {
        version: "1.0",
        sessionAttributes: sessionAttributes,
        response: speechletResponse
    };
}