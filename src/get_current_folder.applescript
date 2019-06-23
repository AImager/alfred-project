on run theQuery
  tell application "Finder"
    set pathList to (quoted form of POSIX path of (folder of the front window as alias))
  end tell

  return pathList
end run