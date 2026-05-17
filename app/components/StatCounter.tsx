"use client";

import { useEffect, useRef, useState } from "react";

interface Props {
  value: number;
  suffix: string;
  prefix?: string;
  duration?: number;
}

export default function StatCounter({ value, suffix, prefix = "", duration = 1400 }: Props) {
  const [display, setDisplay] = useState(0);
  const ref = useRef<HTMLSpanElement>(null);
  const started = useRef(false);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && !started.current) {
          started.current = true;
          const start = performance.now();
          const tick = (now: number) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            setDisplay(Math.round(eased * value * 10) / 10);
            if (progress < 1) requestAnimationFrame(tick);
          };
          requestAnimationFrame(tick);
          observer.disconnect();
        }
      },
      { threshold: 0.5 }
    );
    observer.observe(el);
    return () => observer.disconnect();
  }, [value, duration]);

  const formatted = Number.isInteger(value) ? Math.round(display) : display.toFixed(1);

  return (
    <span ref={ref}>
      {prefix}{formatted}<small>{suffix}</small>
    </span>
  );
}
