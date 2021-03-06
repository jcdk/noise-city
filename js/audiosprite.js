function Track(src, spriteLength, audioLead) {
  var track = this,
      audio = document.createElement('audio');
  audio.src = src;
  audio.autobuffer = true;
  audio.load();
  audio.muted = true; // makes no difference on iOS :(
  
  /* This is the magic. Since we can't preload, and loading requires a user's 
     input. So we bind a touch event to the body, and fingers crossed, the 
     user taps. This means we can call play() and immediate pause - which will
     start the download process - so it's effectively preloaded.
     
     This logic is pretty insane, but forces iOS devices to successfully 
     skip an unload audio to a specific point in time.
     first we play, when the play event fires we pause, allowing the asset
     to be downloaded, once the progress event fires, we should have enough
     to skip the currentTime head to a specific point. */
     
  var force = function () {
    audio.pause();
    audio.removeEventListener('play', force, false);
    if (document.getElementById('btnDwn').style.display != 'none') {
		document.getElementById('btnDwn').style.display = 'none';
		document.getElementById('btnLd').style.display = 'block';
		$('#cspace').addClass('loading');
	}
  };
  
  var progress = function () {

    audio.removeEventListener('progress', progress, false);

    if (track.updateCallback !== null) { 
		track.updateCallback();
	} else {
		document.getElementById('btnLd').style.display = 'none';
		$('#cspace').removeClass('loading');
		document.getElementById('btnDwn').style.display = 'none';
		document.getElementById('btnInit').style.display = 'block';
	}
  };
  
var plprogress = function(){

  // How long is the track in seconds
  var length = audio.duration;
 
  // Whereabouts are we in the track
  var secs = audio.currentTime;
 
  // How far through the track are we as a percentage
  var progresss = (secs / length) * 100;
 
  // Change the width of the progress bar
  if (length > 0) {
 	/* document.getElementById('loadingtrack').innerHTML = 'l- '+Math.round(length)+'/'+Math.round(secs); */
  }
};

  audio.addEventListener('play', force, false);
  audio.addEventListener('play', plprogress, false);
  audio.addEventListener('progress', progress, false);

  var click = document.ontouchstart === undefined ? 'click' : 'touchstart';

  var kickoff = function () {
    audio.play();
    document.documentElement.removeEventListener(click, kickoff, true);        
  };

  document.documentElement.addEventListener(click, kickoff, true);
  
  this.updateCallback = null;
  this.audio = audio;
  this.playing = false;
  this.lastUsed = 0;
  this.spriteLength = spriteLength;
  this.audioLead = audioLead;
}
 
Track.prototype.play = function (position) {
  var track = this,
      audio = this.audio,
      lead = this.audioLead,
      length = this.spriteLength,
      time = lead + position * length,
      nextTime = time + length;
      
  clearInterval(track.timer);
  track.playing = true;
  track.lastUsed = +new Date;
  
  audio.muted = false;
  audio.pause();
  try {
    if (time == 0) time = 0.01; // yay hacks. Sometimes setting time to 0 doesn't play back
    audio.currentTime = time;
    audio.play();
  } catch (e) {
    this.updateCallback = function () {
      track.updateCallback = null;
      audio.currentTime = time;
      audio.play();
    };
    audio.play();
  }
 
  track.timer = setInterval(function () {
    if (audio.currentTime >= nextTime) {
      audio.pause();
      audio.muted = true;
      clearInterval(track.timer);
      player.playing = false;
    }
  }, 10);
};

var player = (function (src, n, spriteLength, audioLead) {
  var tracks = [],
      total = n,
      i;
  
  while (n--) {
    tracks.push(new Track(src, spriteLength, audioLead));
  }
  
  return {
    tracks: tracks,
    play: function (position) {
      var i = total,
          track = null;
          
      while (i--) {
        if (tracks[i].playing === false) {
          track = tracks[i];
          break;
        } else if (track === null || tracks[i].lastUsed < track.lastUsed) {
          track = tracks[i];
        }
      }
      
      if (track) {
        track.play(position);
      } else {
        // console.log('could not find a track to play :(');
      }
    }
  };
})('audio/snd06.mp3', 1, 2, 0.1);

// myaudiosprite.mp3 is the complete audio sprite
// 1 = the number of tracks, increase this for the desktop
// 1 = the length of the individual audio clip
// 0.25 = the lead on the audio - hopefully zero, but in case any junk is added


// Usage: player.play(position)


