<template>
  <div class="zelo-chat" :class="{ 'is-open': isOpen }">
    <Transition name="zelo-panel">
      <div v-if="isOpen" class="zelo-chat-panel" role="dialog" aria-label="Chat with Zelo">
        <header class="zelo-chat-header">
          <div class="zelo-chat-identity">
            <img :src="avatarSrc" alt="" class="zelo-chat-avatar" width="44" height="44" />
            <div>
              <strong>Zelo</strong>
              <span>{{ activeLang.subtitle }}</span>
            </div>
          </div>
          <button type="button" class="zelo-chat-close" aria-label="Close chat" @click="closeChat">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </header>

        <div class="zelo-lang-bar" role="group" aria-label="Chat language">
          <button
            v-for="lang in languages"
            :key="lang.code"
            type="button"
            class="zelo-lang-btn"
            :class="{ 'is-active': language === lang.code }"
            :aria-pressed="language === lang.code"
            :disabled="translating || sending"
            @click="setLanguage(lang.code)"
          >
            {{ lang.label }}
          </button>
        </div>

        <p v-if="translating" class="zelo-translating">Converting chat to {{ activeLang.label }}…</p>

        <div ref="messagesEl" class="zelo-chat-messages" aria-live="polite">
          <div
            v-for="(msg, index) in messages"
            :key="index"
            class="zelo-chat-bubble"
            :class="msg.role === 'user' ? 'is-user' : 'is-bot'"
          >
            <img v-if="msg.role === 'assistant'" :src="avatarSrc" alt="" class="zelo-bubble-avatar" width="28" height="28" />
            <div class="zelo-bubble-body">
              <p>{{ msg.content }}</p>
              <button
                type="button"
                class="zelo-speak-btn"
                :class="{ 'is-active': speakingIndex === index }"
                :aria-label="speakingIndex === index ? 'Stop reading' : 'Read message aloud'"
                :title="speakingIndex === index ? 'Stop' : 'Speak'"
                @click="toggleSpeak(msg, index)"
              >
                <i :class="speakingIndex === index ? 'fa fa-stop' : 'fa fa-volume-up'" aria-hidden="true"></i>
              </button>
            </div>
          </div>
          <div v-if="sending" class="zelo-chat-bubble is-bot is-typing">
            <img :src="avatarSrc" alt="" class="zelo-bubble-avatar" width="28" height="28" />
            <div class="zelo-bubble-body">
              <p><span></span><span></span><span></span></p>
            </div>
          </div>
        </div>

        <p v-if="voiceError" class="zelo-voice-error">{{ voiceError }}</p>

        <form class="zelo-chat-form" @submit.prevent="send">
          <button
            type="button"
            class="zelo-mic-btn"
            :class="{ 'is-listening': listening }"
            :disabled="sending || translating || !speechSupported"
            :aria-label="listening ? 'Stop listening' : 'Speak your message'"
            :title="speechSupported ? (listening ? 'Stop' : 'Speak') : 'Voice input not supported'"
            @click="toggleListen"
          >
            <i class="fa fa-microphone" aria-hidden="true"></i>
          </button>
          <input
            v-model.trim="draft"
            type="text"
            maxlength="2000"
            :placeholder="listening ? activeLang.listeningPlaceholder : activeLang.placeholder"
            autocomplete="off"
            :disabled="sending || translating"
            aria-label="Message Zelo"
          />
          <button type="submit" :disabled="sending || translating || !draft" aria-label="Send message">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
          </button>
        </form>
      </div>
    </Transition>

    <button
      type="button"
      class="zelo-chat-launcher"
      :aria-label="isOpen ? 'Close Zelo chat' : 'Open Zelo chat'"
      :aria-expanded="isOpen"
      @click="toggleOpen"
    >
      <img :src="avatarSrc" alt="Zelo" width="56" height="56" />
    </button>
  </div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import axios from 'axios';
import { img } from '../images';

const LANG_KEY = 'zelo-chat-lang';

const languages = [
  {
    code: 'en',
    label: 'English',
    locale: 'en-IN',
    subtitle: 'Your Proxwebs assistant',
    placeholder: 'Ask Zelo anything…',
    listeningPlaceholder: 'Listening…',
    welcome:
      "Hi! I'm Zelo, your Proxwebs assistant. You can talk to me in English, Hindi, or Malayalam. How can I help you today?",
  },
  {
    code: 'hi',
    label: 'हिन्दी',
    locale: 'hi-IN',
    subtitle: 'आपका Proxwebs सहायक',
    placeholder: 'Zelo से कुछ भी पूछें…',
    listeningPlaceholder: 'सुन रहा हूँ…',
    welcome:
      'नमस्ते! मैं Zelo हूँ, आपका Proxwebs सहायक। आप मुझसे हिंदी, अंग्रेज़ी या मलयालम में बात कर सकते हैं। मैं आपकी कैसे मदद करूँ?',
  },
  {
    code: 'ml',
    label: 'മലയാളം',
    locale: 'ml-IN',
    subtitle: 'നിങ്ങളുടെ Proxwebs സഹായി',
    placeholder: 'Zelo-യോട് ചോദിക്കൂ…',
    listeningPlaceholder: 'കേൾക്കുന്നു…',
    welcome:
      'ഹായ്! ഞാൻ Zelo ആണ്, നിങ്ങളുടെ Proxwebs സഹായി. നിങ്ങൾക്ക് മലയാളം, ഇംഗ്ലീഷ് അല്ലെങ്കിൽ ഹിന്ദിയിൽ സംസാരിക്കാം. എങ്ങനെ സഹായിക്കാം?',
  },
];

const avatarSrc = img('zelo-avatar.png');
const isOpen = ref(false);
const draft = ref('');
const sending = ref(false);
const listening = ref(false);
const speakingIndex = ref(null);
const voiceError = ref('');
const translating = ref(false);
const messagesEl = ref(null);
const voicesReady = ref(false);
const language = ref('en');
const messages = ref([
  {
    role: 'assistant',
    content: languages[0].welcome,
    lang: 'en',
  },
]);

const activeLang = computed(
  () => languages.find((l) => l.code === language.value) || languages[0],
);

const SpeechRecognitionCtor =
  typeof window !== 'undefined'
    ? window.SpeechRecognition || window.webkitSpeechRecognition
    : null;

const speechSupported = computed(() => Boolean(SpeechRecognitionCtor));
let recognition = null;
let cachedVoices = [];
let activeAudio = null;
let speakToken = 0;
let speakAbort = null;

onMounted(() => {
  try {
    const saved = localStorage.getItem(LANG_KEY);
    if (saved && languages.some((l) => l.code === saved)) {
      language.value = saved;
      messages.value = [
        {
          role: 'assistant',
          content: activeLang.value.welcome,
          lang: language.value,
        },
      ];
    }
  } catch (e) {}

  loadVoices();
  if (typeof window !== 'undefined' && window.speechSynthesis) {
    window.speechSynthesis.onvoiceschanged = loadVoices;
  }
});

watch(isOpen, async (open) => {
  if (open) {
    loadVoices();
    await nextTick();
    scrollToBottom();
  } else {
    stopListening();
    stopSpeaking();
  }
});

onBeforeUnmount(() => {
  stopListening();
  stopSpeaking();
  if (typeof window !== 'undefined' && window.speechSynthesis) {
    window.speechSynthesis.onvoiceschanged = null;
  }
});

function loadVoices() {
  if (typeof window === 'undefined' || !window.speechSynthesis) return;
  cachedVoices = window.speechSynthesis.getVoices() || [];
  voicesReady.value = cachedVoices.length > 0;
}

async function setLanguage(code) {
  if (language.value === code || translating.value) return;

  // Always halt any English / Hindi / Malayalam playback immediately
  stopListening();
  stopSpeaking();
  voiceError.value = '';

  const previousLang = language.value;
  const snapshot = messages.value.map((m) => ({
    role: m.role,
    content: m.content,
    lang: m.lang || previousLang,
  }));

  language.value = code;
  recognition = null;

  try {
    localStorage.setItem(LANG_KEY, code);
  } catch (e) {}

  translating.value = true;

  try {
    const { data } = await axios.post('/chat/translate', {
      language: code,
      from_language: previousLang,
      messages: snapshot.map((m) => ({
        role: m.role,
        content: m.content,
      })),
    });

    const translated = Array.isArray(data.messages) ? data.messages : null;

    if (!translated || translated.length !== snapshot.length) {
      throw new Error('Invalid translation response');
    }

    messages.value = translated.map((item, index) => ({
      role: snapshot[index].role,
      content: item.content,
      lang: code,
    }));
  } catch (error) {
    language.value = previousLang;
    recognition = null;
    try {
      localStorage.setItem(LANG_KEY, previousLang);
    } catch (e) {}
    messages.value = snapshot;
    voiceError.value =
      error.response?.data?.message || 'Could not convert the chat. Please try again.';
  } finally {
    // Ensure nothing auto-resumes after language change
    stopSpeaking();
    translating.value = false;
    await nextTick();
    scrollToBottom();
  }
}

function scrollToBottom() {
  const el = messagesEl.value;
  if (el) {
    el.scrollTop = el.scrollHeight;
  }
}

function toggleOpen() {
  isOpen.value = !isOpen.value;
}

function closeChat() {
  isOpen.value = false;
}

function stopSpeaking() {
  speakToken += 1;

  if (speakAbort) {
    try {
      speakAbort.abort();
    } catch (e) {}
    speakAbort = null;
  }

  if (typeof window !== 'undefined' && window.speechSynthesis) {
    try {
      window.speechSynthesis.cancel();
    } catch (e) {}
  }

  if (activeAudio) {
    try {
      activeAudio.onended = null;
      activeAudio.onerror = null;
      activeAudio.pause();
      activeAudio.removeAttribute('src');
      activeAudio.load();
    } catch (e) {}
    activeAudio = null;
  }

  speakingIndex.value = null;
}

function isSpeakActive(token, index) {
  return speakToken === token && speakingIndex.value === index;
}

function scoreVoice(voice, locale, code) {
  const name = (voice.name || '').toLowerCase();
  const lang = (voice.lang || '').toLowerCase();
  const target = locale.toLowerCase();
  let score = 0;

  if (lang === target) score += 100;
  else if (lang.startsWith(target.split('-')[0])) score += 40;

  if (code === 'en') {
    if (lang.includes('en-in') || lang === 'en_in') score += 80;
    if (name.includes('india') || name.includes('indian') || name.includes('raveena') || name.includes('aditi')) {
      score += 60;
    }
  }

  if (code === 'hi') {
    if (lang.includes('hi')) score += 50;
    if (name.includes('hindi') || name.includes('india')) score += 40;
  }

  if (code === 'ml') {
    if (lang.includes('ml')) score += 80;
    if (name.includes('malayalam')) score += 60;
  }

  if (name.includes('natural') || name.includes('neural') || name.includes('google') || name.includes('premium')) {
    score += 25;
  }

  if (name.includes('female') || name.includes('woman') || name.includes('raveena') || name.includes('aditi')) {
    score += 15;
  }

  if (voice.localService) score += 5;

  return score;
}

function pickVoice(code) {
  loadVoices();
  const langMeta = languages.find((l) => l.code === code) || languages[0];
  const locale = langMeta.locale;

  if (!cachedVoices.length) return null;

  const ranked = [...cachedVoices]
    .map((voice) => ({ voice, score: scoreVoice(voice, locale, code) }))
    .sort((a, b) => b.score - a.score);

  if (ranked[0]?.score > 0) return ranked[0].voice;

  return cachedVoices.find((v) => (v.lang || '').toLowerCase().startsWith('en')) || cachedVoices[0];
}

function splitSpeechChunks(text, maxLen = 160) {
  const cleaned = String(text || '').replace(/\s+/g, ' ').trim();
  if (!cleaned) return [];

  const parts = cleaned
    .split(/([.!?…।]+)\s*/)
    .reduce((acc, part) => {
      if (!part) return acc;
      if (/^[.!?…।]+$/.test(part)) {
        if (acc.length) acc[acc.length - 1] += part;
        return acc;
      }
      acc.push(part);
      return acc;
    }, [])
    .map((p) => p.trim())
    .filter(Boolean);

  const chunks = [];

  for (const part of parts) {
    if (part.length <= maxLen) {
      chunks.push(part);
      continue;
    }

    let remaining = part;
    while (remaining.length > maxLen) {
      let cut = remaining.lastIndexOf(' ', maxLen);
      if (cut < 40) cut = maxLen;
      chunks.push(remaining.slice(0, cut).trim());
      remaining = remaining.slice(cut).trim();
    }
    if (remaining) chunks.push(remaining);
  }

  return chunks.length ? chunks : [cleaned];
}

function playAudioBlob(blob, token, index) {
  return new Promise((resolve, reject) => {
    if (!isSpeakActive(token, index)) {
      resolve('stopped');
      return;
    }

    const url = URL.createObjectURL(blob);
    const audio = new Audio(url);
    activeAudio = audio;

    const cleanup = () => {
      URL.revokeObjectURL(url);
      if (activeAudio === audio) activeAudio = null;
    };

    audio.onended = () => {
      cleanup();
      resolve(isSpeakActive(token, index) ? 'ended' : 'stopped');
    };
    audio.onerror = () => {
      cleanup();
      if (!isSpeakActive(token, index)) {
        resolve('stopped');
        return;
      }
      reject(new Error('Audio playback failed'));
    };

    audio.play().catch((err) => {
      cleanup();
      if (!isSpeakActive(token, index)) {
        resolve('stopped');
        return;
      }
      reject(err);
    });
  });
}

async function speakWithCloudVoice(text, langCode, index) {
  const token = speakToken;
  const chunks = splitSpeechChunks(text, 150);
  speakingIndex.value = index;

  const controller = new AbortController();
  speakAbort = controller;

  try {
    for (const chunk of chunks) {
      if (!isSpeakActive(token, index)) return;

      const response = await axios.post(
        '/chat/speak',
        { text: chunk, language: langCode },
        { responseType: 'blob', signal: controller.signal },
      );

      if (!isSpeakActive(token, index)) return;

      const contentType = response.headers['content-type'] || '';
      if (contentType.includes('application/json')) {
        const textBody = await response.data.text();
        const parsed = JSON.parse(textBody);
        throw new Error(parsed.message || 'Speech failed');
      }

      const result = await playAudioBlob(response.data, token, index);
      if (result === 'stopped' || !isSpeakActive(token, index)) return;
    }
  } catch (error) {
    if (axios.isCancel?.(error) || error?.code === 'ERR_CANCELED' || error?.name === 'CanceledError') {
      return;
    }
    if (!isSpeakActive(token, index)) return;
    throw error;
  } finally {
    if (speakAbort === controller) speakAbort = null;
  }

  if (isSpeakActive(token, index)) {
    speakingIndex.value = null;
  }
}

function speakWithBrowserVoice(text, langCode, index) {
  const langMeta = languages.find((l) => l.code === langCode) || activeLang.value;
  const chunks = splitSpeechChunks(text, 220);
  const token = speakToken;
  speakingIndex.value = index;

  let i = 0;

  const speakNext = () => {
    if (!isSpeakActive(token, index)) return;
    if (i >= chunks.length) {
      speakingIndex.value = null;
      return;
    }

    const utterance = new SpeechSynthesisUtterance(chunks[i]);
    const voice = pickVoice(langCode);
    utterance.lang = voice?.lang || langMeta.locale;
    if (voice) utterance.voice = voice;
    utterance.rate = 0.94;
    utterance.pitch = 1.04;
    utterance.volume = 1;

    utterance.onend = () => {
      if (!isSpeakActive(token, index)) return;
      i += 1;
      setTimeout(speakNext, 90);
    };
    utterance.onerror = () => {
      if (!isSpeakActive(token, index)) return;
      speakingIndex.value = null;
    };

    window.speechSynthesis.speak(utterance);
  };

  setTimeout(speakNext, 40);
}

async function toggleSpeak(msg, index) {
  const text = typeof msg === 'string' ? msg : msg?.content;
  const msgLang = typeof msg === 'string' ? language.value : msg?.lang || language.value;

  if (!text || translating.value) return;

  voiceError.value = '';

  if (speakingIndex.value === index) {
    stopSpeaking();
    return;
  }

  stopSpeaking();
  stopListening();

  // Capture token after stopSpeaking so this playback owns the new token
  const startToken = speakToken;
  speakingIndex.value = index;

  // Malayalam & Hindi use cloud TTS for more fluent Indian speech
  if (msgLang === 'ml' || msgLang === 'hi') {
    try {
      await speakWithCloudVoice(text, msgLang, index);
    } catch (error) {
      // Do not restart speech if user switched language / stopped playback
      if (!isSpeakActive(startToken, index)) return;

      speakingIndex.value = null;
      if (typeof window !== 'undefined' && window.speechSynthesis) {
        speakWithBrowserVoice(text, msgLang, index);
      } else {
        voiceError.value = error.message || 'Could not read this message aloud.';
      }
    }
    return;
  }

  if (typeof window === 'undefined' || !window.speechSynthesis) {
    voiceError.value = 'Text-to-speech is not supported in this browser.';
    speakingIndex.value = null;
    return;
  }

  loadVoices();
  speakWithBrowserVoice(text, msgLang, index);
}

function ensureRecognition() {
  if (!SpeechRecognitionCtor) return null;

  if (recognition) {
    recognition.lang = activeLang.value.locale;
    return recognition;
  }

  recognition = new SpeechRecognitionCtor();
  recognition.continuous = false;
  recognition.interimResults = true;
  recognition.maxAlternatives = 3;
  recognition.lang = activeLang.value.locale;

  recognition.onstart = () => {
    listening.value = true;
    voiceError.value = '';
  };

  recognition.onresult = (event) => {
    let transcript = '';
    for (let i = 0; i < event.results.length; i += 1) {
      transcript += event.results[i][0].transcript;
    }
    draft.value = transcript.trim();
  };

  recognition.onerror = (event) => {
    listening.value = false;
    if (event.error === 'not-allowed') {
      voiceError.value = 'Microphone permission denied. Please allow mic access.';
    } else if (event.error === 'language-not-supported') {
      voiceError.value = 'This language is not supported for speech input in your browser. Try Chrome.';
    } else if (event.error !== 'aborted' && event.error !== 'no-speech') {
      voiceError.value = 'Could not capture speech. Please try again.';
    }
  };

  recognition.onend = () => {
    listening.value = false;
  };

  return recognition;
}

function stopListening() {
  if (recognition && listening.value) {
    try {
      recognition.stop();
    } catch (e) {}
  }
  listening.value = false;
}

function toggleListen() {
  if (!speechSupported.value) {
    voiceError.value = 'Voice input is not supported in this browser. Try Chrome or Edge.';
    return;
  }

  voiceError.value = '';

  if (listening.value) {
    stopListening();
    return;
  }

  stopSpeaking();
  const rec = ensureRecognition();
  if (!rec) return;

  rec.lang = activeLang.value.locale;

  try {
    rec.start();
  } catch (e) {
    // Restart if already started
    try {
      rec.stop();
      setTimeout(() => {
        rec.lang = activeLang.value.locale;
        rec.start();
      }, 120);
    } catch (err) {
      voiceError.value = 'Could not start the microphone. Please try again.';
      listening.value = false;
    }
  }
}

async function send() {
  const text = draft.value;
  if (!text || sending.value) return;

  stopListening();
  stopSpeaking();

  const currentLang = language.value;

  messages.value.push({ role: 'user', content: text, lang: currentLang });
  draft.value = '';
  sending.value = true;
  await nextTick();
  scrollToBottom();

  const history = messages.value
    .slice(1, -1)
    .filter((m) => m.role === 'user' || m.role === 'assistant')
    .slice(-12)
    .map((m) => ({ role: m.role, content: m.content }));

  try {
    const { data } = await axios.post('/chat', {
      message: text,
      history,
      language: currentLang,
    });

    messages.value.push({
      role: 'assistant',
      content: data.reply || 'Sorry, I could not reply just now.',
      lang: currentLang,
    });
  } catch (error) {
    messages.value.push({
      role: 'assistant',
      content:
        error.response?.data?.message ||
        'Something went wrong. Please try again, or visit the Contact page.',
      lang: currentLang,
    });
  } finally {
    sending.value = false;
    await nextTick();
    scrollToBottom();
  }
}
</script>

<style scoped>
.zelo-chat {
  position: fixed;
  right: 22px;
  bottom: 22px;
  z-index: 10000;
  font-family: 'Poppins', sans-serif;
}

.zelo-chat-launcher {
  position: relative;
  width: 64px;
  height: 64px;
  border: none;
  border-radius: 50%;
  padding: 0;
  cursor: pointer;
  background: linear-gradient(145deg, #7ec8f5 0%, #03a4ed 55%, #ffb347 100%);
  box-shadow: 0 10px 28px rgba(3, 164, 237, 0.35);
  overflow: hidden;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.zelo-chat-launcher:hover {
  transform: scale(1.06);
  box-shadow: 0 14px 32px rgba(3, 164, 237, 0.45);
}

.zelo-chat-launcher img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.zelo-chat-panel {
  position: absolute;
  right: 0;
  bottom: 78px;
  width: min(380px, calc(100vw - 28px));
  height: min(560px, calc(100vh - 110px));
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 22px;
  overflow: hidden;
  box-shadow: 0 18px 48px rgba(20, 40, 70, 0.22);
  border: 1px solid rgba(3, 164, 237, 0.12);
}

.zelo-chat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 14px 16px;
  background: linear-gradient(135deg, #03a4ed 0%, #4fc3f7 50%, #ffb347 140%);
  color: #fff;
}

.zelo-chat-identity {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 0;
}

.zelo-chat-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  object-fit: cover;
  background: #e8f6fd;
  border: 2px solid rgba(255, 255, 255, 0.85);
}

.zelo-chat-identity strong {
  display: block;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.2;
}

.zelo-chat-identity span {
  display: block;
  font-size: 12px;
  opacity: 0.92;
}

.zelo-chat-close {
  width: 34px;
  height: 34px;
  border: none;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.zelo-chat-close:hover {
  background: rgba(255, 255, 255, 0.32);
}

.zelo-lang-bar {
  display: flex;
  gap: 6px;
  padding: 10px 12px;
  background: #f0f8fc;
  border-bottom: 1px solid rgba(3, 164, 237, 0.1);
}

.zelo-lang-btn {
  flex: 1;
  border: 1px solid #cfeaf8;
  background: #fff;
  color: #2a2a2a;
  border-radius: 999px;
  padding: 6px 8px;
  font-size: 12px;
  font-weight: 600;
  font-family: inherit;
  cursor: pointer;
  transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}

.zelo-lang-btn:hover {
  border-color: #03a4ed;
  color: #03a4ed;
}

.zelo-lang-btn.is-active {
  background: #03a4ed;
  border-color: #03a4ed;
  color: #fff;
}

.zelo-lang-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.zelo-translating {
  margin: 0;
  padding: 8px 14px 0;
  font-size: 12px;
  color: #03a4ed;
  font-weight: 600;
}

.zelo-chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  background:
    radial-gradient(circle at 12% 8%, rgba(3, 164, 237, 0.08), transparent 40%),
    radial-gradient(circle at 88% 18%, rgba(255, 179, 71, 0.12), transparent 36%),
    #f7fbfe;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.zelo-chat-bubble {
  display: flex;
  align-items: flex-end;
  gap: 8px;
  max-width: 92%;
}

.zelo-chat-bubble.is-user {
  align-self: flex-end;
  flex-direction: row-reverse;
}

.zelo-chat-bubble.is-bot {
  align-self: flex-start;
}

.zelo-bubble-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
  background: #dff2fb;
}

.zelo-bubble-body {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 4px;
  min-width: 0;
}

.zelo-chat-bubble.is-user .zelo-bubble-body {
  align-items: flex-end;
}

.zelo-chat-bubble p {
  margin: 0;
  padding: 10px 14px;
  border-radius: 16px;
  font-size: 13.5px;
  line-height: 1.55;
  white-space: pre-wrap;
  word-break: break-word;
}

.zelo-chat-bubble.is-bot p {
  background: #fff;
  color: #2a2a2a;
  border: 1px solid rgba(3, 164, 237, 0.12);
  border-bottom-left-radius: 6px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.zelo-chat-bubble.is-user p {
  background: #03a4ed;
  color: #fff;
  border-bottom-right-radius: 6px;
}

.zelo-speak-btn {
  width: 28px;
  height: 28px;
  border: none;
  border-radius: 50%;
  background: rgba(3, 164, 237, 0.12);
  color: #03a4ed;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.zelo-speak-btn:hover {
  background: #03a4ed;
  color: #fff;
}

.zelo-speak-btn.is-active {
  background: #ff695f;
  color: #fff;
  animation: zelo-pulse 1.2s ease-in-out infinite;
}

.zelo-chat-bubble.is-user .zelo-speak-btn {
  background: rgba(3, 164, 237, 0.18);
  color: #0284c7;
}

.zelo-chat-bubble.is-user .zelo-speak-btn:hover,
.zelo-chat-bubble.is-user .zelo-speak-btn.is-active {
  background: #ff695f;
  color: #fff;
}

.zelo-chat-bubble.is-typing p {
  display: flex;
  align-items: center;
  gap: 5px;
  min-height: 18px;
  padding: 14px 16px;
}

.zelo-chat-bubble.is-typing span {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #03a4ed;
  animation: zelo-dot 1.2s infinite ease-in-out;
}

.zelo-chat-bubble.is-typing span:nth-child(2) {
  animation-delay: 0.15s;
}

.zelo-chat-bubble.is-typing span:nth-child(3) {
  animation-delay: 0.3s;
}

@keyframes zelo-dot {
  0%,
  80%,
  100% {
    opacity: 0.35;
    transform: translateY(0);
  }
  40% {
    opacity: 1;
    transform: translateY(-3px);
  }
}

@keyframes zelo-pulse {
  0%,
  100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.08);
  }
}

.zelo-voice-error {
  margin: 0;
  padding: 6px 14px 0;
  font-size: 12px;
  color: #ff695f;
  line-height: 1.4;
}

.zelo-chat-form {
  display: flex;
  gap: 8px;
  padding: 12px 14px 14px;
  background: #fff;
  border-top: 1px solid rgba(3, 164, 237, 0.1);
}

.zelo-chat-form input {
  flex: 1;
  min-width: 0;
  border: 1px solid #cfeaf8;
  border-radius: 999px;
  padding: 11px 16px;
  font-size: 13.5px;
  outline: none;
  font-family: inherit;
  color: #2a2a2a;
  background: #f7fbfe;
}

.zelo-chat-form input:focus {
  border-color: #03a4ed;
  box-shadow: 0 0 0 3px rgba(3, 164, 237, 0.12);
}

.zelo-chat-form button,
.zelo-mic-btn {
  width: 44px;
  height: 44px;
  border: none;
  border-radius: 50%;
  background: #03a4ed;
  color: #fff;
  cursor: pointer;
  flex-shrink: 0;
  transition: background-color 0.2s ease, opacity 0.2s ease, box-shadow 0.2s ease;
}

.zelo-mic-btn {
  background: #e8f6fd;
  color: #03a4ed;
}

.zelo-mic-btn:hover:not(:disabled) {
  background: #03a4ed;
  color: #fff;
}

.zelo-mic-btn.is-listening {
  background: #ff695f;
  color: #fff;
  box-shadow: 0 0 0 4px rgba(255, 105, 95, 0.25);
  animation: zelo-pulse 1.2s ease-in-out infinite;
}

.zelo-chat-form button:hover:not(:disabled) {
  background: #ff695f;
}

.zelo-chat-form button:disabled,
.zelo-mic-btn:disabled {
  opacity: 0.55;
  cursor: not-allowed;
}

.zelo-panel-enter-active,
.zelo-panel-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.zelo-panel-enter-from,
.zelo-panel-leave-to {
  opacity: 0;
  transform: translateY(12px) scale(0.98);
}

html[data-theme='dark'] .zelo-chat-panel {
  background: #1b2430;
  border-color: rgba(79, 195, 247, 0.18);
}

html[data-theme='dark'] .zelo-lang-bar {
  background: #16202b;
  border-bottom-color: rgba(79, 195, 247, 0.12);
}

html[data-theme='dark'] .zelo-lang-btn {
  background: #243041;
  border-color: rgba(79, 195, 247, 0.2);
  color: #e8eef5;
}

html[data-theme='dark'] .zelo-lang-btn.is-active {
  background: #03a4ed;
  border-color: #03a4ed;
  color: #fff;
}

html[data-theme='dark'] .zelo-chat-messages {
  background:
    radial-gradient(circle at 12% 8%, rgba(3, 164, 237, 0.14), transparent 40%),
    radial-gradient(circle at 88% 18%, rgba(255, 179, 71, 0.1), transparent 36%),
    #121820;
}

html[data-theme='dark'] .zelo-chat-bubble.is-bot p {
  background: #243041;
  color: #e8eef5;
  border-color: rgba(79, 195, 247, 0.16);
}

html[data-theme='dark'] .zelo-speak-btn {
  background: rgba(79, 195, 247, 0.16);
  color: #4fc3f7;
}

html[data-theme='dark'] .zelo-chat-form {
  background: #1b2430;
  border-top-color: rgba(79, 195, 247, 0.12);
}

html[data-theme='dark'] .zelo-chat-form input {
  background: #121820;
  border-color: rgba(79, 195, 247, 0.22);
  color: #e8eef5;
}

html[data-theme='dark'] .zelo-mic-btn {
  background: #243041;
  color: #4fc3f7;
}

@media (max-width: 767px) {
  .zelo-chat {
    right: 14px;
    bottom: 14px;
  }

  .zelo-chat-launcher {
    width: 58px;
    height: 58px;
  }

  .zelo-chat-panel {
    bottom: 72px;
    height: min(75vh, 560px);
  }
}
</style>
