// ── Card Component ───────────────────────────────────────────
import { type HTMLAttributes } from "react";

type CardPadding = "none" | "sm" | "md" | "lg";

interface CardProps extends HTMLAttributes<HTMLDivElement> {
 padding?: CardPadding;
 hoverable?: boolean;
 bordered?: boolean;
}

const paddingClasses: Record<CardPadding, string> = {
 none: "",
 sm: "p-3",
 md: "p-4",
 lg: "p-5",
};

export function Card({
 padding = "md",
 hoverable = false,
 bordered = true,
 children,
 className = "",
 ...props
}: CardProps) {
 return (
 <div
 className={[
 "bg-surface-card rounded-xl shadow-xs",
 bordered ? "border border-slate-200 dark:border-slate-700/80" : "",
 hoverable
 ? "cursor-pointer transition-all duration-150 hover:shadow-sm hover:-translate-y-0.5 active:scale-[0.99]"
 : "",
 paddingClasses[padding],
 className,
 ]
 .filter(Boolean)
 .join(" ")}
 {...props}
 >
 {children}
 </div>
 );
}

