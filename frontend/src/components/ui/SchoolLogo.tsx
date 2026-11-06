// ── School Logo Component ──────────────────────────────────────────
import Image from "next/image";

interface SchoolLogoProps {
  className?: string;
  size?: "sm" | "md" | "lg" | "xl";
  withText?: boolean;
}

export function SchoolLogo({
  className = "",
  size = "md",
  withText = false,
}: SchoolLogoProps) {
  const sizes = {
    sm: { width: 40, height: 40, text: "text-sm" },
    md: { width: 56, height: 56, text: "text-base" },
    lg: { width: 80, height: 80, text: "text-xl" },
    xl: { width: 112, height: 112, text: "text-2xl" },
  };

  const s = sizes[size];

  return (
    <div className={`flex items-center gap-3 ${className}`}>
      <div
        className="shrink-0 relative flex items-center justify-center"
        style={{ width: s.width, height: s.height }}
      >
        <Image
          src="/logo-sekolah.png"
          alt="Logo MTs Soebono Mantofani"
          fill
          className="object-contain"
          priority
        />
      </div>
      {withText && (
        <div className="flex flex-col justify-center">
          <p
            className={`font-bold text-slate-900 dark:text-slate-100 leading-tight ${s.text}`}
          >SIPERKA</p>
          <p className="text-[10px] md:text-xs text-slate-600 dark:text-slate-400 font-medium">
            MTs Soebono Mantofani
          </p>
        </div>
      )}
    </div>
  );
}
