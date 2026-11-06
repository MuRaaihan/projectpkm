// ── PageContainer Component ───────────────────────────────────
"use client";

import { usePathname } from "next/navigation";
import { SideNav } from "./SideNav";

interface PageContainerProps {
  children: React.ReactNode;
  className?: string;
  withBottomNav?: boolean;
}

export function PageContainer({
  children,
  className = "",
  withBottomNav = false,
}: PageContainerProps) {
  const pathname = usePathname();
  const isLogin = pathname === "/login";

  if (isLogin) {
    return (
      <div
        className={["min-h-screen bg-surface transition-theme", className]
          .filter(Boolean)
          .join(" ")}
      >
        {children}
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-surface flex transition-theme">
      <SideNav />
      <div
        className={[
          "flex-1 flex flex-col min-w-0 transition-theme",
          "lg:ml-64",
          withBottomNav ? "pb-16 lg:pb-0" : "",
          className,
        ]
          .filter(Boolean)
          .join(" ")}
        style={{ backgroundColor: "var(--background)" }}
      >
        {children}
      </div>
    </div>
  );
}
