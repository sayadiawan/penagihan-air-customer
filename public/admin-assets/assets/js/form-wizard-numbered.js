"use strict";
$(function () {

  }),
  function () {
    var e = document.querySelector(".wizard-numbered"),
      t = [].slice.call(e.querySelectorAll(".btn-next")),
      l = [].slice.call(e.querySelectorAll(".btn-prev")),
      r = e.querySelector(".btn-submit");
    if (null !== e) {
      const c = new Stepper(e, {
        linear: !1
      });
      t && t.forEach(e => {
        e.addEventListener("click", e => {
          c.next()
        })
      }), l && l.forEach(e => {
        e.addEventListener("click", e => {
          c.previous()
        })
      }), r && r.addEventListener("click", e => {
        alert("Submitted..!!")
      })
    }
  }();
